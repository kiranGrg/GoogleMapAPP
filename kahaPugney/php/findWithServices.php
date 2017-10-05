<div id="search1" style="border-bottom: 1px black dotted">
<table>
    <thead>
        <tr>
            <th colspan="2" id="padhead">
                Service Search:
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Service available:
            </td>
            <td>
                <select name="service_type" id="service_type_id">
                    <option>Select Any</option>
                    <?php 
                    foreach ($services as $service_name) { 
                        ?>
                       <option value="<?php echo $service_name ?>" ><?php echo $service_name ?></option>
                       <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Service Provider:
            </td>
            <td>
                <select name="service_pro" id="service_pro_id" disabled>
                    <option value="">Select Any</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Offered Services:
            </td>
            <td>
                <select name="service_title" id="service_title_id" disabled>
                    <option value="">Select Any</option>
                </select>
                <select id="service_title_no_id"style="visibility: hidden">
                    
                </select>
            </td>
        </tr>
    </tbody>
   <!-- <tfoot>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" value="Find" class="bttn blue" id="service_id"/>
            </td>
        </tr>
    </tfoot>
   -->
</table>
</div>