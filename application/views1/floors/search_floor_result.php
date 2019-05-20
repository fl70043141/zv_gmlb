     <?php
        $i = 0;
         foreach ($search_list as $search){ 
             echo '
                 <tr>
                     <td>'.($i+1).'</td>
                     <td>'.$search['floor_name'].'</td>
                     <td>'.$search['short_name'].'</td>
                     <td>'.$search['hotel_name'].'</td> 
                     <td>
                         <a href="'.  base_url('floors/view/'.$search['id']).'"><span class="fa fa-eye"></span></a> |
                         <a href="'.  base_url('floors/edit/'.$search['id']).'"><span class="fa fa-pencil"></span></a> |
                         <a href="'.  base_url('floors/delete/'.$search['id']).'"><span class="fa fa-trash"></span></a> 
                     </td>  ';
             $i++;
         }
    ?>   