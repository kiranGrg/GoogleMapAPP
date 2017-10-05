<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table>
                        <thead>
                            <tr>
                                <th colspan="2" class="edit_table_header">
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                  Update Type:
                                </td>
                                <td>
                                    <select name="update_type" id="update_type_id" disabled>
                                        <option value="">Select Any</option>
                                        <option value="1">Change Location</option>
                                        <option value="2">Edit Service</option>
                                        <option value="3">Add Service</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  Area:
                                </td>
                                <td>
                                    <input type="text" name="edit_area" id="edit_area_id"disabled />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  Longitude:
                                </td>
                                <td>
                                    <input type="text" name="edit_long" id="edit_long_id" disabled/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   Latitude:
                                </td>
                                <td>
                                     <input type="text" name="edit_lat" id="edit_lat_id" disabled/> 
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Service Titles:
                                </td>
                                <td>
                                    <select name="edit_title" id="edit_title_id" disabled>
                                        <option value="">Select One</option>
                                    </select>
                                    <input type="button" class="btnn yellow" name="edit_show" id="edit_show_id" value="Load" disabled/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Enter title:
                                </td>
                                <td>
                                    <input type="text" name="title" id="enter_title_id" placeholder="Title" disabled/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Details:
                                </td>
                                <td>
                                    <textarea rows="20" cols="40" name="edit_notice" id="edit_notice_id" disabled>
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Availability:
                                </td>
                                <td>
                                    <input type="checkbox" name="edit_service" id="edit_service_id" disabled/>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" class="btnn blue" name="edit" id="edit_id" value="Update" disabled/>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
