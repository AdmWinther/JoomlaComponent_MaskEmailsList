<h1>1. Scope</h1>
This is a Joomla component for making a list of mask emails.
This is a part of my project of making a web application, which provide users with mask emails.
This component allow users to see the list of their mask emails and let them choose if they want to delete any of them.

<h1>2.File Structure</h1>
The original template of this project is git repository admwinther/Joomla Component Template.

```
   .gitignore
│   maskemailslist.xml
│   Readme.md
│
├───admin
│   ├───services
│   │       provider.php   │
│   ├───src
│   │   ├───Controller
│   │   │       DisplayController.php
│   │   └───View
│   │       └───Adminstart
│   │               HtmlView.php
│   └───tmpl
│       └───adminstart
│               default.php
└───site
    ├───services
    │       provider.php
    ├───src
    │   ├───Controller
    │   │       DisplayController.php
    │   │       NewemailformController.php
    │   ├───Model
    │   │   └───Siteinitial
    │   │           SiteinitialModel.php
    │   └───View
    │       └───Siteinitial
    │               HtmlView.php
    └───tmpl
        └───siteinitial
                default.php
                default.xml
```
