<!-- menu.php drop down menus  blame: alexg
     copyright 2015 Robert Clark(aka ebobtron) et al.  -->

    <ul class="menu">
        <li><a href="show">Home</a></li>
        <li><a href="aboutus">About</a></li>
        <li><a href="grpsel">Submit</a></li>
        <li>
            <a href="boardselect">Leader Boards &#9662;</a>
            <ul class="dropdown">
                <li><a href="show" class="disabled">Unique </a></li>
                <li><a href="show?t=a">All &nbsp; <?= $amark?></a></li>
                <li><a href="archive">Prior Year</a></li>
            </ul>
        </li>
        <li>
            <a href="grpInfo">More &#9662;</a>
            <ul class="dropdown">
                <li><a href="prior_results">Charts</a></li>
                <li><a href="legalstff" class="disabled">Copyright Information</a></li>
            </ul>
        </li>
    </ul>


