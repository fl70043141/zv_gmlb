<?php
//echo '<pre>'; print_r($all_report_columns);die
?>      
 <table class="table datatable">
        <thead>
            <tr>
                
                <th>#</th>
                <?php
//                $col_val = 1;
                    foreach ($report_columns as $report_column){
                        echo '<th>'.$all_report_columns[$report_column].'</th>';
                    }
                ?>
            </tr>
        </thead>
        <tbody>
         <?php
//var_dump($search_list); die;
    $i = 0;
     foreach ($search_list as $row){ 
        echo '<tr>  '
                . '<td>'.($i+1).'</td>';
        foreach ($report_columns as $report_column){
                        echo '<td>'.$row[$report_column].'</td>';
                    }
                
        $i++;
    }
?> 

        </tbody>
    </table>           
 