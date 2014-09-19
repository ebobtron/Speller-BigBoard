<?php  

$comment = <<< EDO
Kate from Washington, D.C.<br />
<br />
I used a hash function I found on the Internet (ELF, from a library compiled by ArashPartow), and created a global array of size 65,535 to store the hash results, all pointing to linked lists.<br />
<br />
Following a suggestion made by "delipity" in a reddit thread, every time a word is found, I move it to the head of its linked list (if it is not already there), on the theory that the most common words should be at or near the beginning of each list.&nbsp; I am sure there are ways to optimize the process of changing chars to lower case, but I didn't try to figure that out.
<br /><br />

EDO;

?>
