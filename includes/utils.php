<?php
//$filtered_query=array(10);
session_start(); // DO CALL ON TOP OF BOTH PAGES
//$_SESSION['array'] = $filtered_query;
//echo $_SESSION['array']; // GIVES SAME $array FOR BOTH PAGES
function set_filtered_posts(array $query){
    $temp=array();

    $_SESSION['array']=array_merge($temp,$query);
    //print_r($_SESSION['array']);
}

function set_filtered_more_posts(array $query){

    $_SESSION['array']=array_merge($_SESSION['array'],$query);
    //print_r($_SESSION['array']);
}

function get_filtered_posts(): array{
    //print_r($_SESSION['array']);

    return $_SESSION['array'];
}

function set_excluded_id_terms(int $id, String $filter_name){

    /*print_r($_SESSION['exluclude_array']);
    if (empty($_SESSION['exluclude_array'])){
        $filter_format = get_id_array_taxonomies( 'term_id','format' );
        $filter_categorie = get_id_array_taxonomies( 'term_id','categorie' );
        $_SESSION['exluclude_array']= array_merge($filter_format,$filter_categorie);
    }
    $pos_filter = array_search($id,$_SESSION['exluclude_array']);
	print_r($pos_filter);
	unset($_SESSION['exluclude_array'][$pos_filter]);
    print_r($_SESSION['exluclude_array']);*/
    $temp=array();
    $_SESSION['exluclude_array'][$filter_name]=$id;
    $_SESSION['exluclude_array']=array_merge($temp,$_SESSION['exluclude_array'] );
    print_r($_SESSION['exluclude_array']);
}

function get_excluded_id_terms(): array{
    //print_r($_SESSION['exluclude_array']);

    return $_SESSION['exluclude_array'];
}