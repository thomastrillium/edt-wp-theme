var hoverObjs=[];jQuery(document).ready(function($){$("polygon, line, polyline").on("click",function(){}),$("polygon, line, polyline").on("mouseenter",function(){}),$("#hovers_1_").find("polygon, path").on("mouseenter click",function(){var o=$(this).attr("id").split("_")[0],e=$("#stroke-paths > path, #stroke-paths > g");$.each(e,function(e,n){if(-1!==$(n).attr("id").indexOf(o)){var t=$(n).find("polygon, line, polyline, path");t.css("stroke-width","30px"),t.css("stroke","white"),hoverObjs.push(t),hoverObjs.push($(n)),$.each(hoverObjs,function(o,e){$(e).css("stroke-width","30px"),$(AhoverItem).css("stroke","white")})}})}).on("mouseout mouseleave",function(){hoverObjs.length>0&&($.each(hoverObjs,function(o,e){console.log("clearing: "+e.attr("id")),$(e).css("stroke-width","10px")}),hoverObjs=[])})});