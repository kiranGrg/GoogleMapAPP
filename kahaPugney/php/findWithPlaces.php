
<div id="search1" style="border-bottom: 1px black dotted">
    <table class="pan23table">
        <thead>
            <tr>
                <th colspan="2" id="padhead">
                    You are at Bagdhol, Lalitpur
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <table class="pan23table1">
                        <tbody>
                            <tr>
                                <td>
                                    <label>Find Nearest: <input type="checkbox" value="near" 
                                                                id="nearCheck"/>
                                        <label>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Search Area:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="selectType" id="a1_type">
                                                        <option value="">Select Area</option>
                                                        <?php foreach ($areas as $area) {
                                                            ?>
                                                            <option value="<?php echo $area ?>" ><?php echo $area ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Search Place Type:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="selectType" id="p1_type">
                                                        <option value="">Select Place Type</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td>
                                                        Specify Destination:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <!--<td id="auto">
                                                        <input type="text" value="Enter The Destination" 
                                                               onBlur="if(this.value==''){this.value='Enter The Destination'}" 
                                                               onFocus="if(this.value==''||this.value=='Enter The Destination'){this.value=''}" 
                                                               id="destination" disabled="disabled"/>
                                                    </td>
                                                    -->
                                                    <td>
                                                        <select class="selectType" id="destination" >
                                                            <option value="">Select Destination</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            </table>
                                            </td>
                                            <td>
                                                <table class="pan23tabl2">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                Type of Route :
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="radio" id="modeDrive" name="travelmode" value="DRIVING" onClick="" checked/><label for="modeDrive">Driving</label> 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="radio" id="modeWalking" name="travelmode" value="WALKING" /><label for="modeWalking">Walking</label> 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <!--<input type="radio" id="modeCycle" name="travelmode" value="BICYCLING" /><label for="modeCycle">Bicycling</label> -->
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                                        <tr>
                                                            <td>
                                                                <input type="submit" class="bttn blue" value="Search" id="search"/>   
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                            </table>

                                            </div>
