<table>
                        <thead style="border-bottom: 3px #000000 solid;">
                        <tr>
                        <th colspan ="2">
                            Welcome to Service Section
                        </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Type of Institution:
                                </td>
                                <td>
                                    <select name="type" id="type_id">
                                        <option vlaue="">Select</option>
                                        <?php foreach ($types as $type) {
                                            ?>
                                            <option value="<?php echo $type ?>" ><?php echo $type ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px #000000 dashed">
                                <td>
                                    Any of it:
                                </td>
                                <td>
                                    <select name="type" id="type_name_id">
                                        <option vlaue="">Select Any</option>
                                    </select>
                                    Load Data: <input type="checkbox" id="checked_id" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Name:
                                </td>
                                <td>
                                    <input type="text" name="name" autofocus="true" id="name_id" placeholder="Enter the name"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Area:
                                </td>
                                <td>
                                    <input type="text" name="area" id="area_id" placeholder="Enter the area"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Longitude:
                                </td>
                                <td>
                                    <input type="text" name="long" id="long_id" placeholder="Longitude of a place" disabled/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Latitude:
                                </td>
                                <td>
                                    <input type="text" name="lat" id="lat_id" placeholder="Latitude of a place" disabled/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Service title:
                                </td>
                                <td>
                                    <input type="text" name="title" id="title_id" placeholder="Title"/>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    Description:
                                </td>
                                <td>
                                    <textarea rows="22" cols="30" name="notice" id="notice_id">
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Availability:
                                </td>
                                <td>
                                    <input type="checkbox" name="service" id="service_id"/>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" class="btnn blue" name="add" id="add_id" value="Publish"/>
                                </td>
                                    
                            </tr>
                        </tfoot>

                    </table>

<!--edit layout section -->

