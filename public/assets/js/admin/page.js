/*
 *  Document   : page.js
 *  Author     : 
 *  Description: 
 *
 */
$(document).ready(function(){
	$(".pageActionButton").on("click", function() {
		var $this = $(this);
		var pageId = $this.data("pageid");
		var actionType = $this.data("actiontype");
		$("#pageActionField_pageId").val(pageId);
		$("#pageActionField_actionType").val(actionType);
		$('#modal-fadein').modal({show:true});
	});
});