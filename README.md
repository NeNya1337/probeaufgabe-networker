Prerequisites to use this service:
* clone the repository into a folder, where /public represents the web root of the server
* configure your database in file config/db.ini
* start public/install.php to create the table in our DB
* OR create a database and import the config/db.sql into it.

Usage:
* click on "Datei auswählen" to choose the file to load (use .csv)
* after this, click "Senden", this will import the data from the selected file. On every successful import, it will send the respective mail
* this can take some time, please be patient
* after complete you will see, how many records were imported and mails sent
* the "exportieren" button will create an CSV with all the records, that were confirmed (positive and negative) by the users
* the file will be named [timestamp]export.csv e.g. 2022-05-16-13-37-42export.csv
* the data will be sorted by the answer of the confirmation and data of confirmation. This information is provided, too.

Mailing:
* The user will receive a mail with two links, either to stay on mailing list or to be deleted.
* clicking on one link sends the user to a page, where he has to confirm his selection
* after this, his record will be updated respectively
* even the user confirmation links are secured by a random, non-suggestible hash, it's send via GET, so no change of data is issued after link clicking in email
* the final change is issued by sending a form via POST