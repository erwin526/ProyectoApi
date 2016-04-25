
<?php


    // connect to mysql
    $link = mysql_connect( 'localhost', 'root', 'esiney' );

    // select the database
    mysql_select_db('test', $link);

 $_SESSION["usuario"]=$row['Usuario'];
    // create an array to hold the references
    $refs = array();

    // create and array to hold the list
    $list = array();

    // the query to fetch the menu data
    $sql = "call menu(1)";
 $_SESSION["usuario"]=$sql;

    // get the results of the query
    $result = mysql_query($sql);

    // loop over the results
    while($data = @mysql_fetch_assoc($result))
    {
        // Assign by reference
        $thisref = &$refs[ $data['sisId'] ];

        // add the the menu parent
        $thisref['MenuPadre'] = $data['MenuPadre'];
        $thisref['Menu'] = $data['Menu'];
        $thisref['Url'] = $data['Url'];

        // if there is no parent id
        if ($data['MenuPadre'] == 0)
        {
            $list[ $data['sisId'] ] = &$thisref;
        }
        else
        {
            $refs[ $data['MenuPadre'] ]['children'][ $data['sisId'] ] = &$thisref;
        }
    }

    /**
    *
    * Create a HTML list from an array
    *
    * @param    array    $arr
    * @param    string    $list_type
    * @return    string
    *
    */

 function create_list( $arr )
    {
        
       
        $html .= "\n<ul>\n";
        foreach ($arr as $key=>$v) 
        {
            $html .= '<a href='.$v['Url'].'> ';
            $html .= '<li>'.$v['Menu']."</li>\n";
             $html .= '</a>';
            if (array_key_exists('children', $v))
            {
           // li para ordenar las listas     $html .= "<li>";
             //   $html .= "<a href='".$v['menu_item_name']."'>"; 
                $html .= create_list($v['children']);
             //li fin de orden de lista   $html .= "</li>\n";
                $html .= "</a>\n";
            
            }
            else{}
        }
        $html .= "</ul>\n";
        return $html;
    }

 

echo  "\n<div>\n".  $_SESSION['usuario']. "\n</div>\n";
echo "<div> hola mundo </div> " ;

    echo create_list( $list );

?>