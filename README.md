# Spring15-bamboo
Setup Instructions:
1. Install Xampp
2. Paste entire folder as is to C:\xampp\htdocs\
3. Go to localhost/phpmyadmin
4. Create a database called dataviz
5. Select the database and choose import
6. Browse and select the sql file present in the SQL folder.
7. goto localhost/dataviz/[pagename]

There are 2 pages that display different Gantt chart views.
1. overview.php shows the symptom duration and med timings
2. kick_in.php shows the kickin durations for meds.

The both require GET variables in the URL to display data

overview.php: http://localhost/dataviz/overview.php?from=2015-04-01&to=2015-04-02&symptom=SF0
Here from is the start date and to is the end date. symptom is the symptom code you are monitoring

kick_in.php: http://localhost/dataviz/kick_in.php?from=2015-04-01&to=2015-04-02
Here from is the start date and to is the end date.

data_analysis.php is the page that converts raw logs to processed events.
