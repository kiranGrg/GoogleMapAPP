    <table class="pan1table">
        <thead>
            <tr>
                <th colspan="2" id="padhead">
                    Single Click on Map to get Info:
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    You pointed at:
                </td>
                <td>
                    <input type="text" id="place" value="Enter the Name"
                           onBlur="if(this.value == ''){this.value = 'Enter the Name'}"
                           onFocus="if(this.value == '' || this.value == 'Enter the Name'){this.value = ''}"/>
                </td>
            </tr>
            <tr>
                <td>
                    Latitude:
                </td>
                <td>
                    <input type="text" id="lat" disabled/>
                </td>
            </tr>
            <tr>
                <td>
                    Longitude:
                </td>
                <td>
                    <input type="text" id="lon" disabled/>
                </td>
            </tr>
            <tr>
                <td>
                    Area: 
                </td>
                <td>
                    <input type="text" id="area" disabled/>
                </td>
            </tr>
            <tr>
                <td>
                    Type: 
                </td>
                <td>
                    <select id="p2_type" class="selectType">
                        <option value="">Type of Place</option>
                        <option value="hospital">Hospital</option>
                        <option value="clinic">Clinic</option>
                        <option value="school">School</option>
                        <option value="college">College</option>
                        <option value="atm">ATM Booth</option>
                        <option value="bank">Bank</option>
                        <option value="hotel">Hotel</option>
                        <option value="restaurant">Restaurant</option>
                        <option value="supermarket">Supermarket</option>
                        <option value="vehicle point">Vehicle Park</option>
                        <option value="institute">Institute</option>
                        <option value="junctions">Chowks</option>
                        <option value="parks">Parks</option>
                        <option value="temple">Temple</option>
                        <option value="cinema">Cinema</option>
                        <option value="petrolpump">Petrol Pump</option>
                        <option value="showroom">Show Rooms</option>
                        <option value="auto-workshop">Auto-workshop</option>
                        <option value="other">Other Places</option>
                    </select>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" id="insert" class="bttn blue" value="Save Data"/>
                </td>
            </tr>
        </tfoot>

    </table> 