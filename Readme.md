<h2>1. Joomla Components</h2>
The structure of a simple Joomla component is as follows:

<<<<<<< HEAD
```
pppppækcom_mycomponent/
=======
```com_mycomponent/
>>>>>>> 5c352b9e9851d88daeed18d08b4f56c6f9fb94bf
│
├── admin/                      # Backend (administrator) files
│   ├── services/                   # Services
│   │   └── provider.php
│   ├── src/                     # Models
│   │   ├── Controller/             # Controllers (Single!)
│   │   │   └── DisplayController.php
│   │   ├── View/                   # View (Single!) 
│   │   └── yourviewname/
│   │       └── HtmlView.php
│   └── tmpl/
│       └── yourviewname/
│           └── default.php
<<<<<<< HEAD
└── mycomponent.xml          # Manifest (tells Joomla what’s here)
```
=======
└── mycomponent.xml          # Manifest (tells Joomla what’s here)```
>>>>>>> 5c352b9e9851d88daeed18d08b4f56c6f9fb94bf

Attention:
1. The component name must start with "com_".
2. The manifest file must be in the root, named the same as the component name and in xml format.
3. Backend files must be in the "admin" folder. it includes services, src, and tmpl.
4. /admin/services/provider.php is the starting point of the backend.
5. /admin/src/ contains the MVC structure. Subfolders must be named Controller, View, and Model
6. /admin/src/Controller/ MUST CONTAIN A FILE NAMED DisplayController.php which provides a class named DisplayController, with a method named display().
7. /admin/src/View/ CAN CONTAIN A FILE NAMED HtmlView.php which provides a class named HtmlView, with a method named display(). This method could be used to load data from the model and pass it to the template.
8. /admin/tmpl/ contains the view templates. Each subfolder must be named after the view name, the same as subforlders in /admin/src/View/
9. /admin/tmpl/yourviewname/default.php is the default template file for the view named "yourviewname".

<h2> 2. Joomla component with Site<h2>
Now, if the component includes a front side, it would look like this:

<<<<<<< HEAD
```
com_mycomponent/
=======
```com_mycomponent/
>>>>>>> 5c352b9e9851d88daeed18d08b4f56c6f9fb94bf
│
├── admin/                      # Backend (administrator) files
│   ├── services/                   # Services
│   │   └── provider.php
│   ├── src/                     # Models
│   │   ├── Controller/             # Controllers (Single!)
│   │   │   └── DisplayController.php
│   │   ├── View/                   # View (Single!) 
│   │   └── yourviewname/
│   │       └── HtmlView.php
│   └── tmpl/
│       └── yourviewname/
│           └── default.php
├── site/                      # Frontend (site) files
│   ├── src/                     # Models
│   │   ├── Controller/             # Controllers (Single!)
│   │   │   └── DisplayController.php
│   │   ├── View/                   # View (Single!) 
│   │   └── yourviewname/
│   │       └── HtmlView.php
│   └── tmpl/
│       └── yourviewname/
│           ├── default.xml
│           └── default.php
└── mycomponent.xml          # Manifest (tells Joomla what’s here)```

The content of "site" folder follow the same as "admin" folder but:
1. There is no need for /services/provider.php
2. The tmpl folder has an extra default.xml file for each view. That is just to name a view in the menu, or something a like.
