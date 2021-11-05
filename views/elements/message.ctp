<?php
	/* Wyświetlenie komunikatu systemowego */
	echo $this->Session->flash()
?>

<?php
	/* Wyświetlenie komunikatu z systemu autoryzacji */
	echo $this->Session->flash('auth')
?>