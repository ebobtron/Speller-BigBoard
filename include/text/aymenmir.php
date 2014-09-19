<?php

$comment = <<< EDO
Aymen from Srinagar, Kashmir.<br />
<br />
I've minimized the number of mallocs in my program by creating a global array of nodes. There is another method of resolving collisions - I think it is called open addressing. David mentions it briefly during Lecture 14. Using open addressing, I've stored all words in the dictionary in the global array. So basically, I don't have to unload anything.<br />
<br />
Using bit wise operators to convert all characters to lower case alphabets decreases the total time as this method doesn't involve any conditions. There is a short on ASCII from week 0 that has a detailed explanation. (A friend of mine had this idea first).<br />
<br />
My hash function is pretty simple. It involves a bit wise or between  two successive chars. <br />
 It's basically<blockquote style="font-family:Monaco, monospace"> 
hash = (hash &lt;&lt; i) * (word[i] ^ word[i + 1])</blockquote>

That's pretty much it.<br /><br />
EDO;

?>
