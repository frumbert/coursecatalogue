# coursecatalogue

Renders a tab-based catalogue.

[screenshot](pix/screenshot.png)

Tabs names are sub-categories of the root category (curently hard coded as category id = 1)

Tabs are visible only when one or more courses within that category would show.

Courses are listed with:

* shortname
* description
* course image
* custom fields representing various labels
    * "tab" (multiselect menu), e.g. "e-elearning"
    * "topics" (multiselect menu) e.g. "communication"

## Site admins see more

A handy 'Manage courses' shortcut button is added for site admins. Shortcuts to the course EDIT screen and COMPLETION report screen are added.

The labels for courses also show extra custom fields for admins

  * "listed" (checkbox) e.g. "yes"
  * "visible" (course visiblity flag) e.g "visible"

# Setup

Install and Enable the filter on the site homepage or wherever you want the content to appear

Add the shortcode [course-catalogue] to the page.

Enable or add your own CSS for styling ...

# Default css

There is no default css specified for the plugin. You will have to supply custom css through the theme. Here is the SCSS I started with


```css

$catalogue-gap: 20px;

.tab-catalogue-course {
display:grid;
grid-template-columns: repeat(auto-fill, minmax(512px, 1fr) );
gap: $catalogue-gap;
margin:0;
}

.tab-catalogue > input {
  display:block; /* "enable" hidden elements in IE/edge */
  position:absolute; /* then hide them off-screen */
  left:-100%;
}

.tab-catalogue > ul {
  position:relative;
  z-index:999;
  list-style:none;
  display:flex;
  margin-bottom:-1px;
  padding: 0;
  -webkit-margin-start: 0;
}

.tab-catalogue > ul label,
.tab-catalogue > div {
  border:1px solid $tab-border;
}

.tab-catalogue > ul label {
  display:inline-block;
  padding:0.75rem 1.5rem;
  background:$tab-dark;
  border-right-width:0;
  margin-bottom: 0;
}

.tab-catalogue > ul li:first-child label {
  border-radius:0.5em 0 0 0;
}

.tab-catalogue > ul li:last-child label {
  border-right-width:1px;
  border-radius:0 0.5em 0 0;
}

.tab-catalogue > div {
  position:relative;
  background: $tab-light;
  border-radius:0 0.5em 0.5em 0.5em;
  margin-top: -1px;
}

.tab-catalogue > input:nth-child(1):focus ~ ul li:nth-child(1) label,
.tab-catalogue > input:nth-child(2):focus ~ ul li:nth-child(2) label,
.tab-catalogue > input:nth-child(3):focus ~ ul li:nth-child(3) label,
.tab-catalogue > input:nth-child(4):focus ~ ul li:nth-child(4) label,
.tab-catalogue > input:nth-child(5):focus ~ ul li:nth-child(5) label,
.tab-catalogue > input:nth-child(6):focus ~ ul li:nth-child(6) label,
.tab-catalogue > input:nth-child(7):focus ~ ul li:nth-child(7) label,
.tab-catalogue > input:nth-child(8):focus ~ ul li:nth-child(8) label,
.tab-catalogue > input:nth-child(9):focus ~ ul li:nth-child(9) label {
	text-decoration:underline;
}

.tab-catalogue > input:nth-child(1):checked ~ ul li:nth-child(1) label,
.tab-catalogue > input:nth-child(2):checked ~ ul li:nth-child(2) label,
.tab-catalogue > input:nth-child(3):checked ~ ul li:nth-child(3) label,
.tab-catalogue > input:nth-child(4):checked ~ ul li:nth-child(4) label,
.tab-catalogue > input:nth-child(5):checked ~ ul li:nth-child(5) label,
.tab-catalogue > input:nth-child(6):checked ~ ul li:nth-child(6) label,
.tab-catalogue > input:nth-child(7):checked ~ ul li:nth-child(7) label,
.tab-catalogue > input:nth-child(8):checked ~ ul li:nth-child(8) label,
.tab-catalogue > input:nth-child(9):checked ~ ul li:nth-child(9) label {
  background: $tab-light;
  border-bottom-color: $tab-light;
}

.tab-catalogue > div > section,
.tab-catalogue > div > section h2 {
  position:absolute;
  top:-999em;
  left:-999em;
}

body.ie11 .alc-list-item {
margin-bottom: $catalogue-gap;
}
 
.tab-catalogue > div > section {
  // padding:1em 1em 0;
padding: $catalogue-gap;
}

.tab-catalogue > input:nth-child(1):checked ~ div > section:nth-child(1),
.tab-catalogue > input:nth-child(2):checked ~ div > section:nth-child(2),
.tab-catalogue > input:nth-child(3):checked ~ div > section:nth-child(3),
.tab-catalogue > input:nth-child(4):checked ~ div > section:nth-child(4),
.tab-catalogue > input:nth-child(5):checked ~ div > section:nth-child(5),
.tab-catalogue > input:nth-child(6):checked ~ div > section:nth-child(6),
.tab-catalogue > input:nth-child(7):checked ~ div > section:nth-child(7),
.tab-catalogue > input:nth-child(8):checked ~ div > section:nth-child(8),
.tab-catalogue > input:nth-child(9):checked ~ div > section:nth-child(9) {
  position:Static;
}

.tab-catalogue > ul label {
  -webkit-touch-callout:none;
  -webkit-user-select:none;
  -khtml-user-select:none;
  -moz-user-select:none;
  -ms-user-select:none;
  user-select:none;
}

.alc-list-item {

    position: relative;
    padding: $catalogue-gap;
    // margin: 20px 0px 20px 0px;
    background: #fff;

    .alc-list-link,
    .alc-list-link:visited,
    .alc-list-link:visited:hover {
        clear: both;
        text-decoration: none;
        font-size: 24px;
        color: #0055A2;
        line-height: 24px;
        font-weight: 700;
        display: block;
        padding: 10px 5px 10px 0px;
    }

    .alc-list-image {
        display: block;
        min-height: 155px;
        max-height: 200px;
        background: #cccccc;
        text-decoration: none;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }
    .alc-list-labels > span {
        background: #808080;
        color: #fff;
        margin: 0px 10px 5px 0px;
        padding: 1px 5px 0px 5px;
        border: 1px solid #808080;
        display: block;
        float: left;
        border-radius: 2px;
        font-size: 10px;
        &.topic {
            background: #909090;
        }
        &.admin {
            color: black;
            &.l {
                background-color: lightskyblue;
            }
            &.u {
                background-color: darkseagreen;
            }
            &.h {
                background-color: orangered;
                color: white;
            }
           &.v {
                background-color: yellowgreen;
           }
        }
    }
    .alc-list-date {
        position: absolute;
        right: 5px;
        top: 0;
        width: 65px;
        background-color: #0055A2;
        color: #fff;
        font-weight: bold;
        font-size: 14px;
        text-decoration: none;
        line-height: 15px;
        text-align: center;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding: 10px;
        a {
            color: white;
        }
    }
}
```

# Licence

Same as Moodle