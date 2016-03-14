Copyright 2016 Institut fuer Lern-Innovation,Friedrich-Alexander-Universitaet Erlangen-Nuernberg, GPLv3 or later, see LICENSE

Includes a modified core part of STACK version 3.3
Copyright 2012 University of Birmingham
licensed under GPLv3 or later, see classes/stack/COPYING.txt
http://stack.bham.ac.uk

================================
ILIAS STACK Question Type Plugin.
================================

- Author: Jesus Copado <jesus.copado@fim.uni-erlangen.de>, Fred Neumann <fred.neumann@fim.uni-erlangen.de>
- Forum: http://www.ilias.de/docu/goto_docu_frm_3474_2766.html
- Bug Reports: http://www.ilias.de/mantis (Choose project "ILIAS plugins" and filter by category "STACK Question Type")

This plugin is an ILIAS port of STACK, developed by Chris Sangwin. It provides a test question type
for mathematical questions that are calculated by a the Computer Algebra System (CAS) Maxima.
See the original STACK documentation at http://stack.bham.ac.uk/moodle

Additional Software Requirements
--------------------------------

* Maxima (http://maxima.sourceforge.net)

Maxima is a open sorce computer algebra system and part of most Linux distributions.
A version for windows is available, too. Maxima needs to be installed on the web server running
your ILIAS installation.
Either install the package from your linux distribution or download and install it from
sourceforge (http://sourceforge.net/projects/maxima/files/)

* GNUplot (http://www.gnuplot.info)

GNUplot is used by maxima to generate graphical plots of functions etc. It is freely available
and part of most Linux distrubutions. GNUplot needs to be installed on the web server
running your ILIAS and maxima installations.
Either install the package from your linux distribution or download and install it from
sourceforge (http://sourceforge.net/projects/gnuplot/files/)

* MathJax (http://www.mathjax.org)

MathJax is an open source JavaScript display engine for mathematics. It is used by the STACK plugin
to display maths in question, user input validation and feedback. It can either be linked from
cdn.mathjax.org or downloaded to your own web server. It has to be configured in ILIAS:

1. Go to Administration > Third Party Software > MathJax
2. Enable MathJax and enter the URL to MathJax (local or proposed cdn)
3. Save

First Installation of the plugin
--------------------------------

1. Copy the assStackQuestion directory to your ILIAS installation at the followin path
(create subdirectories, if neccessary):
Customizing/global/plugins/Modules/TestQuestionPool/Questions/assStackQuestion

2. Go to Administration > Plugins
3. Choose action "Update" for the assStackQuestion plugin
4. Choose action "Activate" for the assStackQuestion plugin
5. Choose action "Refresh Languages" for the assStackQuestion plugin

Update from version 1
---------------------

Version 1 and version 2 share the same internal id (xqcas) but have different names
and require different ILIAS versions:

- Version 1: assCasQuestion (ILIAS 4.4)
- Version 2: assStackQuestion (ILIAS 5.0)

Steps to update the plugin:
1. Update ILIAS to version 5 
   (the assCasQuestion plugin is deactivated by that step)
2. Copy the assStackQuestion folder to Customizing/global/plugins/Modules/TestQuestionPool/Questions/
3. Go to Administration > Plugins
4. Choose action "Update" for the assStackQuestion plugin
   (all settings and questions of assCasQuestion will be migrated to assStackQuestion) 
5. Choose action "Activate" for the assStackQuestion plugin
6. Delete the assCasQuestion folder from Customizing/global/plugins/Modules/TestQuestionPool/Questions/


Configuration and test of the plugin
------------------------------------

1. Go to Administration > Plugins
2. Choose action "Configure" for the assStackQuestion plugin
3. Set the platform type and maxima version according your installation
4. Go to the tab "Health Check" and click "Do Health Check"
5. If some checks are not passed, click "Show Debugging Data" to get more information

Import of questions from moodleXML
----------------------------------

1. Create an ILIAS question pool
2. Click "Create question", choose "Stack Question" and click "Create"
3. Click "Create Question from MoodleXML"
4. Select a moodleXML package on your computer and click "Import"

Usage of STACK questions
------------------------

You can work with a STACK question like any other question in ILIAS. You can preview it in the question pool
and already try it out there. You can copy it to an ILIAS test and use it there.  A a test participant you will
normally answer a question in two steps. First you enter your answer as a formula in an input field and click "Validate"
beneath that field to check how your input is interpretet. This will give you a graphical version of you entry which may
already be simplified. If you entry can't be interpreted, you will get an error message. When you are satisfied with your
input you can evaluate your answer (in self assessment mode) or move to the next question (in an exam).


===============
Version History
===============

* Versions 2.3 and higher (for ILIAS 5.0, ILIAS 5.1 and higher) are maintained in GitHub: https://github.com/ilifau/assStackQuestion
* Former versions can be found in ILIAS SVN: http://svn.ilias.de/svn/ilias/branches/fau/plugins, but are not longer updated


GitHub Version 2.3.1 (2016-03-14)
---------------------------------
This version includes some ideas from SIG Mathe+ILIAS Meeting in Bremen. like The links to the authoring guides in the head of the authoring page.
And solve problems with Linux installations and creaation of non-full unit test.
+The following bugs have been solved
- http://ilias.de/mantis/view.php?id=17358 regarding Matrix in STACK, now matrix also allows |,{ and "" as matrix parents.
- http://ilias.de/mantis/view.php?id=18091 regarding Matrix best solutions, now best solution have a Matrix form without matrix parents.
- http://ilias.de/mantis/view.php?id=18081 regarding Error message.
- http://ilias.de/mantis/view.php?id=18069 regarding navigation from tabs within STACK and evaluable previews.


GitHub Version 2.3.0 (2016-02-29)
---------------------------------
- STACK plugin can be used in ILIAS 5.0 and ILIAS 5.1 versions.
- New feedback report system:
- New ILIAS feedback tab, it works like in the other ILIAS question types and is ILIAS only, cannot be exported to Moodle. This feedback is shown when
  "feedback on fully correct answer" or "Feedback" options is activated in test settings. This feedback report appears always under the question text and
  there is two different messages, one qhen the question is correct and other if it is not fully correct. This is a normal Text and cannot contain CASText.
- Inline feedback is allowed. Feedback placeholders can be included into the question text, if done, the specific feedback for a PRT will appear within the
  question text, if not, the feedback placeholder must be in the specific feedback, a normal text area where the specific feedback will appear
  By default, specific feedback will appear under the question text. This feedback is shown when "Specific Feedback for Each Answer provided" or "Feedback" option
  are checked, then the specific feedback will be shown under the question text.
- Best solution is now displayed in the ILIAS way, like a question text filled in with the correct answer (model answer). Under this the how to solve (general feedback)
  is shown in case it exist. If there is no model answer in an input, best solution for that input will not be shown. Best solution is shown when "Show best possible answer"
  or "best solution" is checked.
- In question preview, STACK Evaluation button is not longer used, now the ILIAS check button is used to send the user answer in previews.
- The adaptation process to the new feedback system makes that all questions with no feedback placeholders will get automatically one feedback placeholder per PRT in
  the specific feedback field. Teachers can move this placeholder to the question text if they want.
+The following bugs have been solved:
- http://www.ilias.de/mantis/view.php?id=17984 regarding export to Moodle.
- http://www.ilias.de/mantis/view.php?id=17989 regarding using of the plugin with ILIAS 5.1
- http://www.ilias.de/mantis/view.php?id=15904 regarding order in PRT feedback
- http://www.ilias.de/mantis/view.php?id=16915 regarding feedback report.
- http://www.ilias.de/mantis/view.php?id=15088 regarding feedback report.
- http://www.ilias.de/mantis/view.php?id=16074 regarding feedback report.
- http://www.ilias.de/mantis/view.php?id=16665 regarding random variables in preview.
- http://www.ilias.de/mantis/view.php?id=16640 regarding feedback report.
- http://www.ilias.de/mantis/view.php?id=16645 regarding feedback report.
- http://www.ilias.de/mantis/view.php?id=17774 regarding using of previous answer


SVN Version 2.2.1 (2016-02-22)
------------------------------
Extended HTML support with images and tables in rich text fields, also with import and export. This solves the following bugs:
- http://www.ilias.de/mantis/view.php?id=17345
- http://www.ilias.de/mantis/view.php?id=17345


SVN Version 2.2.0 (2015-12-14)
------------------------------
- Added Export to MoodleXML functionality. A new sub-tab in question editing allows to export to MoodleXML format the current question or all the questions of the current question pool where the question is in.
* The export to MoodleXML doesn't work if the question have images.
+ The following bugs have been solved in this version:
- http://www.ilias.de/mantis/view.php?id=17531 regarding Errors when a node have no points given.
- http://www.ilias.de/mantis/view.php?id=16879 regarding Errors when a node have no points given.
- http://www.ilias.de/mantis/view.php?id=17390 regarding Errors when a node have no points given.
- http://www.ilias.de/mantis/view.php?id=17377 regarding @0@ forbidden expression.
- http://www.ilias.de/mantis/view.php?id=17116 regarding import/export from pool.
- http://www.ilias.de/mantis/view.php?id=17634 regarding translations to German.
- http://www.ilias.de/mantis/view.php?id=17472 regarding translations to German.
+ The following bug have a temporary solution:
- http://www.ilias.de/mantis/view.php?id=17345 regarding Tables and Images in TinyMCE, Now in authoring interface tables and images are always allowed.
- http://www.ilias.de/mantis/view.php?id=17195 regarding Question with no titles, Now you don't get an blank page when creates a question with no text, but the changes are not saved.

SVN Version 2.1.8 (2015-10-23)
------------------------------
- Added support for the FormATest plugin
- Translated some messages to German

SVN Version 2.1.7 (2015-10-21)
-----------------------------
+ The following bugs have been solved in this version:
- http://www.ilias.de/mantis/view.php?id=16669 regarding Editing in test, copy to question pool.
- http://www.ilias.de/mantis/view.php?id=17072 regarding formating in general feedback.
- Formating is now also activated in nodes specific feedback.
- http://www.ilias.de/mantis/view.php?id=16946 regarding the validation button.
- http://www.ilias.de/mantis/view.php?id=17068 regarding error creating questions.
- Added sopme error messages.


SVN Version 2.1.6 (2015-09-30)
-----------------------------
+ The following bugs have been solved in this version:
- http://www.ilias.de/mantis/view.php?id=16742 regarding unusual order of nodes in a PRT.
- http://www.ilias.de/mantis/view.php?id=16727 regarding duplicate question notes.
- http://www.ilias.de/mantis/view.php?id=16783 regarding dissapearance of question text.
- Include a small bugfix will try to solve the following bug: http://www.ilias.de/mantis/view.php?id=15904 in OPTES.
- Added some error messages missing.


SVN Version 2.1.5 (2015-09-23)
-----------------------------
+ The following bugs have been solved in this version:
- http://www.ilias.de/mantis/view.php?id=16633 regarding check button in previews error.
- http://www.ilias.de/mantis/view.php?id=15972 regarding seeds used in tests.
- http://www.ilias.de/mantis/view.php?id=15986 regarding error with allowed words.
- http://www.ilias.de/mantis/view.php?id=16426 regarding answer note/question note.
- http://www.ilias.de/mantis/view.php?id=16211 regarding penalties in unit test.
- http://www.ilias.de/mantis/view.php?id=16073 regarding validation button looks like.
- http://www.ilias.de/mantis/view.php?id=16100 regarding question variables.
- http://www.ilias.de/mantis/view.php?id=16635 regarding missing t in info message.
- http://www.ilias.de/mantis/view.php?id=16644 regarding prt names.


SVN Version 2.1.4 (2015-03-04)
-----------------------------
+ The following bugs have been solved in this version:
- http://www.ilias.de/mantis/view.php?id=14362 Regarding rectangular brackets problem when importing.
- http://www.ilias.de/mantis/view.php?id=15391 Regarding incorrect order of PRT when more than 9 PRT in a question.
- http://www.ilias.de/mantis/view.php?id=14566 Regarding validation in Text area inputs
- http://www.ilias.de/mantis/view.php?id=14483 Regarding validation in Single character inputs
- http://www.ilias.de/mantis/view.php?id=14534 Regarding validation in Matrix inputs

SVN Version 2.1.1 (2015-03-04)
------------------------------
+ STACK core classes have been updated to the last 3.3 version.
+ Instant validation is now available when in server mode. By checking the instant validation in the configuration of the plugin, all the questions of the platform will use the instant validation system which avoids clicking to validate an answer, the answer will be validated automatically two seconds after finish write in the input field. This option is available for algebraic input only.
+ Preview of questions with deployed seeds now show a fixed version of the question using always the same seed if it has been fixed. To fix a seed to a preview go to the Seed label and click on see preview in the selected seed. This choice works during the session of the user.
The following errors in Mantis have been solved:
-	No test results, when user doesn’t answer a question. http://www.ilias.de/mantis/view.php?id=14370, http://www.ilias.de/mantis/view.php?id=14793
-	Inverse trigonometric functions aren’t displayed as set in the settings. http://www.ilias.de/mantis/view.php?id=14198
-	Never-ending but CPU-high consuming call. http://www.ilias.de/mantis/view.php?id=14680
-	Problems with evaluation in question preview. http://www.ilias.de/mantis/view.php?id=13965
-	Problems importing question with < or > in the text or variables. http://www.ilias.de/mantis/view.php?id=14094 http://www.ilias.de/mantis/view.php?id=15068
Other issues have been solved as problems when importing question pools or test, also copying or moving the questions to other question pool.

SVN Version 2.0.2 (2015-02-05)
------------------------------
* Added the "Server" option to the configuration of the Maxima Connection
* Bug fixes

SVN Version 2.0.1 (2014-12-23)
------------------------------
* intermediate version 


SVN Version 2.0.0 (2014-12-03)
------------------------------
* first version 2 published in SVN
* alpha version of the question authoring interface
* for version 1 history see http://svn.ilias.de/svn/ilias/branches/fau/plugins/assCasQuestion/README
