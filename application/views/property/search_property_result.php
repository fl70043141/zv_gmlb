<?php
//var_dump($search_list); die;
    $i = 0;
     foreach ($search_list as $search){ 
         echo '
             <tr>
                 <td>'.($i+1).'</td>
                 <td>'.$search['property_name'].'</td>
                 <td>'.$search['short_name'].'</td>
                 <td>'.$search['prop_type_name'].'</td> 
                 <td>'.$search['hotel_name'].'</td> 
                 <td>
                     <a href="'.  base_url('property/view/'.$search['id']).'"><span class="fa fa-eye"></span></a> |
                     <a href="'.  base_url('property/edit/'.$search['id']).'"><span class="fa fa-pencil"></span></a> |
                     <a href="'.  base_url('property/delete/'.$search['id']).'"><span class="fa fa-trash"></span></a> 
                 </td>  ';
         $i++;
     }
?>       

 