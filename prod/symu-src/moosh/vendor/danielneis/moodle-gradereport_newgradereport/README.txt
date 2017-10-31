The following steps should get you up and running with
this grade report template code.

* DO NOT PANIC!

* Unzip the archive and read this file

* Rename the newgradereport/ folder to the name of your report (eg "widget").
  The report folder MUST be lower case. You should check the CVS contrib
  area at http://moodle.org/plugins to make sure that
  your name is not already used by an other module. Registering the plugin
  name @ http://moodle.org/plugins will secure it for you.

* Edit all the files in this directory and its subdirectories and change
  all the instances of the string "newgradereport" to your report name
  (eg "widget"). If you are using Linux, you can use the following command
  $ find . -type f -exec sed -i 's/newgraderport/widget/g' {} \;

* Rename the file lang/en/newmodule.php to lang/en/gradereport_widget.php
  where "widget" is the name of your report 

* Place the widget folder into the /grade/report folder of the moodle
  directory.

* Modify version.php and set the initial version of you report .

* Visit Settings > Site Administration > Notifications, you should find
  the report's tables successfully created

* Go to Site Administration > Grades > Report settings
  and you should find that this new grade report has been added to the list of
  installed grade reports.

* You may now proceed to run your own code in an attempt to develop
  your report. You will probably want to modify index.php
  as a first step. Check db/access.php to add capabilities.

We encourage you to share your code and experience - visit http://moodle.org

Good luck!
