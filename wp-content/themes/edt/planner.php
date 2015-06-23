<?php // planner ?> 
<div id="planner-holder" class="centered max-width" >
	<div id="planner-box">
		<div id="planner-form-holder">
			<div id="trip-planner-title" class="trip-planner-label">Trip Planner</div>
			
			
			<form id="planner-form" name="f" action="http://jump.trilliumtransit.com/redirect.php" target="_blank">
			<table>
			<tr>
		
 
			
				<input type="hidden" name="ie" value="UTF8"/>
			<input type="hidden" name="f" value="d"/>
			<td>	<span class="minimized-hidden"><label for="saddr"><strong>Start</strong></label></span>
			<td>
			   <input type="text" style="width:18em" size="15" name="saddr" maxlength="2048" id="saddr"/>
			<span class="minimized-hidden">	<font size="-2">e.g. 1655 Iron Point Road, Folsom, CA</font></span>
            </td>

<span class="minimized-hidden">

<td>
	<label for="daddr"><strong>End</strong></label>
	<td><input type="text" style="width:18em" size="15" name="daddr" id="daddr" maxlength="2048"/><input type="hidden" name="sll" value="38.660592,-120.995730"/><br/>
	<span class="minimized-hidden"><font size="-2">e.g. Marshal Medical Center</font></span>
</td>
<td>
<font size="-1"><input type="radio" id="leave" name="ttype" value="dep" checked="checked" tabindex="1"/>
<label for="leave">Depart at</label> <span>&nbsp;or</span> <input type="radio" id="arrive" name="ttype" value="arr" tabindex="1"/>
<label for="arrive">Arrive by</label></font>
</td>
<td>
<label for="fdate" class="obscure">Date</label><font size="-1">
<input type="text" id="fdate" size="10" name="date" value="" tabindex="1" maxlength="100"/> 
<td>
<label for="ftime" class="obscure">Time</label>
<input type="text" id="ftime" size="10" name="time" value="" tabindex="1" maxlength="100"/></font>
</td>

<input type="hidden" value="261" name="agency"/>
<input type="hidden" name="sort" value="walk"/>
<!--[default set above is for "Less walking". alternative options to insert above are:
value=“def”   <— "Best route"
value=“num"    <— “Fewest transfers"] -->
	<td>
		<input type="submit" value="Get Directions"/>


	</td>
	</tr>
</table>
</span><!-- class="minimized-hidden" -->

</form>

		</div> <!-- end id="planner-form-holder" -->
		<div id="expand-planner-button" >
			<span class="open">
			 &#10095;
			</span>
			<span class="close">Close</span>
		</div> <!-- end id="expand-planner-button" -->
	</div><!-- end #planner-box -->
	
</div> <!-- end planner-holder -->


<?php
?>