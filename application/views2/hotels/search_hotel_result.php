     <?php
        $i = 0;
         foreach ($search_list as $search){ 
             echo '
                 <tr>
                     <td>'.($i+1).'</td>
                     <td>'.$search['hotel_name'].'</td>
                     <td>'.$search['city'].'</td>
                     <td>'.$search['phone'].'</td> 
                     <td>
                         <a href="'.  base_url('hotels/view/'.$search['id']).'"><span class="fa fa-eye"></span></a> |
                         <a href="'.  base_url('hotels/edit/'.$search['id']).'"><span class="fa fa-pencil"></span></a> |
                         <a href="'.  base_url('hotels/delete/'.$search['id']).'"><span class="fa fa-trash"></span></a> 
                     </td>  ';
             $i++;
         }
    ?>   