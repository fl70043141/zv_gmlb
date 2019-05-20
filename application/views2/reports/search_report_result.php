      
 <table class="table datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>Report Number</th>
                <th>Customer</th>
                <th>Species</th>
                <th>variety</th>
                <th>Weight</th>
                <th>Shape</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         <?php
//var_dump($search_list); die;
    $i = 0;
     foreach ($search_list as $row){ 
        echo '
            <tr>
                <td>'.($i+1).'</td>
                <td>'.$row['report_no'].'</td>
                <td>'.$row['customer_name'].'</td>
                <td>'.$row['identification_val'].'</td>
                <td>'.$row['variety_val'].'</td>
                <td>'.$row['weight'].'</td>
                <td>'.$row['shape_val'].'</td> 
                <td>
                    <a href="'.  base_url('reports/view/'.$row['id']).'"><span class="fa fa-eye"></span></a> |
                    <a href="'.  base_url('reports/edit/'.$row['id']).'"><span class="fa fa-pencil"></span></a> |
                    <a href="'.  base_url('reports/delete/'.$row['id']).'"><span class="fa fa-trash"></span></a> 
                </td>  ';
        $i++;
    }
?> 

        </tbody>
    </table>           
 