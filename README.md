# ADISE21_WelcomeToTheJungle

QUARTO GAME BY THANASIS KAREZOS && PERIKLIS CHRISTOS GOUSIOS

Το project που υλοποιηθηκε αναφερεται στο μαθημα Ανάπτυξη Διαδικτυακών
Συστημάτων και Εφαρμογών του Τμήματος Μηχανικών Πληροφορικής και Ηλεκτρονικών Συστημάτων ΔΙΠΑΕ.

Αναφερεται σε ενα Board Game ονοματο Quarto.

Απαιτήσεις

Apache2
Mysql Server
php
PostMan [https://www.postman.com/]


Οδηγίες Εγκατάστασης

Κάντε clone το project σε κάποιον φάκελο $ git clone https://github.com/iee-ihu-gr-course1941/ADISE21_WelcomeToTheJungle.git

Βεβαιωθείτε ότι ο φάκελος είναι προσβάσιμος από τον Apache Server. πιθανόν να χρειαστεί να καθορίσετε τις παρακάτω ρυθμίσεις.

Θα πρέπει να δημιουργήσετε στην Mysql την βάση με όνομα 'Board' και να φορτώσετε σε αυτήν την βάση τα δεδομένα από το αρχείο schema.sql

Θα πρέπει να φτιάξετε το αρχείο ../../db_upass.php το οποίο να περιέχει:

<?php
    if(!defined('Access')) {
       die('Direct access not permitted');
    }
    $DB_PASS = 'κωδικος';
    $DB_USER = 'ονομα';
?>

Περιγραφή Παιχνιδιού

Το Quarto είναι ένα επιτραπέζιο παιχνίδι για δύο παίκτες που εφευρέθηκε από τον Ελβετό μαθηματικό Blaise Müller.

Το παιχνίδι παίζεται σε ταμπλό 4×4. Υπάρχουν 16 μοναδικά κομμάτια για να παίξετε, καθένα από τα οποία είναι είτε:

Long or Short
White or Brown
Square or Cycle
With leak or not

Οι παίκτες διαλέγουν ένα κομμάτι το οποίο πρέπει να τοποθετήσει ο άλλος παίκτης στο ταμπλό. Ένας παίκτης κερδίζει τοποθετώντας ένα κομμάτι στον πίνακα που σχηματίζει μια οριζόντια, κάθετη ή διαγώνια σειρά τεσσάρων κομματιών, τα οποία έχουν όλα μια κοινή ιδιότητα (όλα κοντά, όλα κυκλικά κ.λπ.).

Συντελεστές

θανασης Καρεζος : Jquery , Σχεδιασμός mysql
Περικλης Χρηστος Γουσιος: Jquery , Σχεδιασμός mysql

Περιγραφή API

Methods

Login

Εισοδος Login
POST / LOGIN
Καθορισμός στοιχείων παίκτη

Δημιουργία Register
POST / Register
Εγραφη του χρηστη

Ελεγχος Checkstatus
GET / checkstatus
Επιστροφη το στατους του παιχνιδιου

Εμφανιση Showboard
GET / showboard
Εμφανιση του πινακα Board 

Εμφανιση Showpieces
GET / showpieces
Εμφανιση τον διαθεσημων πιονιων

Τοποθετηση Place
POST / PLACE
Βαζει το πιονι που επιλεχτικε στην θεση που θελει ο χρηστης


Επιλογη Pick
POST / pick
Επιλεγει ο χρηστης το πιονι του αντιπαλου

Τοποθετηση JoinGame
POST / joinGame
Προσθετει τον χρηστη στο παιχνιδι


Επαναφορα ResetGame
POST / resetGame
Επαναφερει το παιχνιδι στην θεση 0

Board
Το board είναι ένας πίνακας, ο οποίος στο κάθε στοιχείο έχει τα παρακάτω:

Attribute	Description	                   Values
x       H συντεταγμένη x του τετραγώνου         1..4
y	    H συντεταγμένη y του τετραγώνου        	1..4
piece	To Πιόνι που υπάρχει στο τετράγωνο	    1...16, null

Pieces
Attribute	    Description                             	  Values
pieces_id	Μοναδικός αριθμός	                              1...16S
is_light	Άν είναι λευκό η μαύρο	                       'Black','White'
is_round	Αν είναι στρόγγυλο η τετράγωνο	               'cycle','square'
is_short	Αν είναι κοντό η ψηλό	                       'short','long'
is_solid	Αν έχει βαθουλωτή κορυφή ή συμπαγής κορυφή	   'YES','NO'
available	Είδος κίνησης που πρέπει να κάνει ο παίκτης	   'TRUE','FALSE'



Users
O κάθε παίκτης έχει τα παρακάτω στοιχεία:

Attribute	        Description	               Values
ID      	    Μόναδικος άυξων αριθμος 	ΙΝΤ INCREMENT
username	        Όνομα παίκτη            String,UNIQUE
email	            email παικτη                HEX
password	      Κωδικος παικτη	'        pick','place'
token	        To κρυφό token του παίκτη.    timestamp



Game_status
Attribute	        Description                     	Values
status	            Κατάσταση	        'not active', 'initialized', 'started', 'ended', 'aborded'
turn	        Η κατασταση που καθοριζεται ο παιχτης       TINYINT(1,2)
state	           κατασταση παιχτη                         pick or place
piece	        αποθηκευει το πιονι που επαιξε και επελεξε να παιξει ο καθε παιχτης             (κραταει  ενα log file το οποιο δειχνει την καθε κινηση)
change	            προσθηκη χρονου                     timestamp
won                 δηλωνει οταν το status_game γινει end game ποιος νικησε text