<?php 
  if(isset($_GET['page'])){
    switch ($page = $_GET['page']) {
    	case '0':
    		$menu0 = "active";
    		break;
    	case '1':
    		$menu1 = "active";
    		break;
    	case '2':
    		$menu2 = "active";
    		break;
    	case '3':
    		$menu3 = "active";
    		break;
    	case '4':
    		$menu4 = "active";
    		break;
    	case '5':
			$menu5 = "active";
			$menumix = "active";
			$collapse5 = "show";
    		break;
		case '6':
			$menumix = "active";
			$menu6 = "active";
			$collapse5 = "show";
    		break;
    	case '7':
    		$menu7 = "active";
    		break;

    	
    	default:
    		# code...
    		break;
    }
  }
?>