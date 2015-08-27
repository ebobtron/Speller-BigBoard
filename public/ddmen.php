<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>dropdown menus</title>
</head>

<style>

    ul.menu{
        border: 0px solid green;
        margin:0;
        padding: 0;
        list-style: none;
        /*background: #f2f2f2;*/
        text-align: center;
        font-size: 1.1em;
    }
    .menu li{
        display: inline-block;
        position: relative;
        line-height: 21px;
        text-align: left;
    }
    .menu li a{
        display: block;
        padding: 8px 18px;
        color: #333;
        text-decoration: none;
    }
    .menu li a:hover{
        color: #fff;
        background: #939393;
    }
    .menu li .dropdown{
        min-width: 100%; /* Set width of the dropdown */
        background: #f2f2f2;
        padding: 0;
        display: none;
        position: absolute;
        z-index: 999;
        left: 0;
    }
    .menu li:hover .dropdown{
        display: block;	/* Display the dropdown */
    }
    .menu li .dropdown li{
        display: block;
    }
    

</style>

    <ul class="menu">
        <li><a href="">Home</a></li>
        <li><a href="">About</a></li>
        <li><a href="">Submit</a></li>
        <li>
            <a href="">Leader Boards &#9662;</a>
            <ul class="dropdown">
                <li><a href="">Unique</a></li>
                <li><a href="">All</a></li>
                <li><a href="">Prior Year</a></li>
            </ul>
        </li>
        <li>
            <a href="#">More &#9662;</a>
            <ul class="dropdown">
                
                <li><a href="">Charts</a></li>
                <li><a href="">Copyright Information</a></li>
            </ul>
        </li>
    </ul>


</html> 
