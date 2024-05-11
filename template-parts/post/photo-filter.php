<div class="filter-area">
    <form class="filter-form" method="post" >
    <div class="filterleft">    
            <div id="filtre-categorie" class="select-filter flexcolumn">   
                <span class="categorie_id-down arrowfilters arrowfilters-arrow-down select-close"></span>
                <select class="option-filter" name="categorie_id" id="categorie_id">
                    <!-- Génération automatique de la liste des catégories en fonction de ce qu'il y a dans WP -->
                    <option id="categorie_0" value="">Catégories</option>
                    <?php
                        $categorie_cpt = get_terms('categorie', array('hide_empty' => false)); 
                        //$categorie = get_post_meta( '25', 'categorie', true );
                        //print_r($categorie);
                        //var_dump($categorie_cpt);
                        //var_dump($categorie_cpt[0]->name);
                        //print_r($categorie_cpt[1]->name);
                        $output="";
                        if ( !empty($categorie_cpt) ) {
                            
                            foreach( $categorie_cpt as $category ) {
                                $output.= '<option id="categorie_'. esc_attr( $category->term_taxonomy_id ) .'" value="'. esc_attr( $category->term_taxonomy_id ) .'">'. esc_html( $category->name ) .'</option>';
                            }
                        }
                        echo $output;
                    ?>
                </select>
            </div>
            <div id="filtre-format" class="select-filter flexcolumn">   
                <span class="format_id-down arrowfilters arrowfilters-arrow-down select-close"></span>
                <select class="option-filter" name="format_id" id="format_id">
                    <!-- Génération automatique de la liste des catégories en fonction de ce qu'il y a dans WP -->
                    <option id="format_0" value="">Formats</option>
                    <?php
                        $format_cpt = get_terms('format', array('hide_empty' => false)); 
                        $output="";
                        if ( !empty($format_cpt) ) {
                            
                            foreach( $format_cpt as $format ) {
                                $output.= '<option id="'. esc_attr( $format->term_taxonomy_id ) .'" value="'. esc_attr( $format->term_taxonomy_id ) .'">
                                        '. esc_html( $format->name ) .'</option>';
                            }
                            
                        }
                        echo $output;
                    ?>
                </select>
            </div>
        </div>
        <div class="filterright">
                <div id="filtre-date" class="select-filter flexcolumn">       
                    <span class="date-down arrowfilters arrowfilters-arrow-down select-close"></span>
                    <select class="option-filter" name="date" id="date">
                        <option value="">Trier par</option>
                        <option value="desc">nouveauté</option>
                        <option value="asc">Les plus anciens</option>
                    </select>
                </div>
        </div>        
    </form>
</div>