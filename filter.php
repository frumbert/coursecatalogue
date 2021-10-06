<?php

/*

Creates a course catalogue with tabs across the top and courses down the page.
The format of the course list is set by template

Lists courses in categories under the specified (root) category

Usage:
- Enable the filter for the frontpage.
- In an editable region such as the default topic, place the tag [course-catalogue] where the catalogue will appear.

*/

class filter_coursecatalogue extends moodle_text_filter {
    public function filter($text, array $options = array()) {

		global $DB, $CFG, $PAGE;

		$find = "[course-catalogue]";
		$root = 1; // hard coded category id

        if (!isset($CFG->filter_coursecatalogue_template)) {
			return str_replace($find, '', $text);
        }
		if (strpos($text,$find)!==false) {

			$i = 0;
			$vis = is_siteadmin() ? "visible = 1" : "1";

			$categories = $DB->get_records_sql("
				select id, name
				from {course_categories}
					where $vis
					and parent = {$root}
				order by sortorder
			");

			$objdata = new stdClass();
			$objdata->categories = [];

			if (is_siteadmin()) {
				$link = (new moodle_url('/course/management.php',['categoryid'=>0]))->out();
				$button = html_writer::tag('button', 'Manage courses', ['class' => 'btn btn-success pull-right']);
				$objdata->management = new stdClass();
				$objdata->management->button = html_writer::link($link, $button);
			}

			$i=0;
			foreach ($categories as $category) {
				$courses = $DB->get_records_sql("
					select id, fullname, summary, visible
					from {course} where category = {$category->id}
					order by sortorder
				");

				$c = new stdClass();
				if ($i ===0) $c->first = 1;
				$c->id = $category->id;
				$c->title = $category->name;
				$c->courses = [];

				foreach ($courses as $course) {
					$r = new stdClass();

					if (!is_siteadmin() && strval($course->visible) !== "1")	{
						continue;
					}
					
					$r->id = $course->id;
					$r->title = $course->fullname;
					$r->description = content_to_text($course->summary, FORMAT_PLAIN);
					$r->labels = [];
					$r->image = "/filter/coursecatalogue/pix/no-course.jpg";

					// get the course image
					$crs = new \core_course_list_element($course);
					foreach ($crs->get_course_overviewfiles() as $file) {
						$isimage = $file->is_valid_image();
						$course_image_url = file_encode_url("$CFG->wwwroot/pluginfile.php",
								'/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
								$file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
						if ($isimage) {
							$r->image = $course_image_url;
						}
					}

					// get the metadata
					$listed = false;
					foreach ($crs->get_custom_fields() as $field) {
						$fd = new \core_customfield\output\field_data($field);
						$n = $fd->get_shortname();
						$v = $fd->get_value();
						switch ($n) {
							case "tab": $r->labels[] = ["css"=>"tab", "text"=>$v]; break;
							case "topics": $r->labels[] = ["css"=>"topic", "text"=>$v]; break;
							// case "description": $r->description = ["css"=>"description", "text"=>$v]; break;
							case "listed": if (is_siteadmin()) $r->labels[] = ["css"=>"admin " . (strval($v) === "Yes" ? "l" : "u"), "text" => (strval($v) === "Yes" ? "Listed" : "Unlisted")]; break;
						}
					}

					// handy links for admins
					if (is_siteadmin())	{
						$r->admin = true;
						$r->labels[] = ["css"=>"admin " . (strval($course->visible) === "1" ? "v" : "h"), "text"=> (strval($course->visible) === "1" ? "Visible" : "Hidden")];
					}

					$c->courses[] = $r;
				}
				if (count($c->courses) > 0) {
					$objdata->categories[] = $c;
				}
				$i++;
			}
			$obj = new \filter_coursecatalogue\output\tabs($objdata);
			$renderer = $PAGE->get_renderer('filter_coursecatalogue');
			$text = $renderer->render($obj);
		}

		return $text;
    }
}
