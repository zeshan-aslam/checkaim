var Alerts = window.Alerts || {};
Alerts.PageNo = 1;

Alerts.Common = function () {
    return {
        Init: function () {
	
			Alerts.Action.GetAlerts();
		
			$("#divPagination").on("click", ".pageno", function(){

				Alerts.PageNo = $(this).data("pageno");
				Alerts.Action.GetAlerts();

			});

			$("#divPagination").on("click", ".next", function(){

				Alerts.PageNo = Alerts.PageNo + 1;
				Alerts.Action.GetAlerts();

			});

			$("#divPagination").on("click", ".previous", function(){

				Alerts.PageNo = Alerts.PageNo - 1;
				Alerts.Action.GetAlerts();

			});

			$('#modalAlertDetails').on('show.bs.modal', function (e) {
		  
 						var alertid = $(e.relatedTarget).data("alertid");
 			
 					Alerts.Action.GetAlertsDetails(alertid);

				});

			$('#modalAlertDetails').on('hidden.bs.modal', function (e) {
		  
 						   $("#divAlertDetails").html("");
								

				});

        }
    }
}();

Alerts.Action = function () {
    return {
        GetAlerts: function(success){
		
		if(typeof(success) == "undefined")
		{
		 success = function (response, status) {
                        
						console.log(response);
						
						if(response != null)
						{
							
								var html = "";
								var source = $("#alerts-template").html();
								var template = Handlebars.compile(source);
								html = template(response.data);	
								
								$("#divAlerts").html(html);

								source = $("#pager-template").html();
								template = Handlebars.compile(source);
								html = template(response);	
								$("#divPagination").html(html);

								var pager = response.pager;

								if(Alerts.PageNo == 1)
								{
									$("#divPagination .previous").hide();
								}
								else
								{
									$("#divPagination .previous").show();
								}

								if(pager.totalpages == Alerts.PageNo)
								{
									$("#divPagination .next").hide();
								}
								else
								{
									$("#divPagination .next").show();
								}
							
								
						}	
						
                   };
		}

			var postData = {'alerts_list':"yes", pageno: Alerts.PageNo};
			var headerData =  {
				
			};
			var url = "/controller/alerts.php";

			Alerts.Ajax.Request('POST', postData, url, success);
		
		},
		GetAlertsDetails: function(alertid, success){

			if(typeof(success) == "undefined")
			{
			 success = function (response, status) {
	                        
							console.log(response);
							
							if(response != null)
							{
								
									console.log(response);

		 							var source = $("#alertdetails-template").html();
				                    var template = Handlebars.compile(source);
				                    var html = template(response);

				                    $("#divAlertDetails").html(html);
								
									
							}	
							
	                   };
			}

			var postData = {'alert_details':"yes", 'alertid': alertid};
			var headerData =  {
				
			};
			var url = "/controller/alerts.php";
		
		 	Alerts.Ajax.Request('POST', postData, url, success);
		
		}
		
		
    }
}();



Alerts.Ajax = function () {
    return {
        Request: function (requestType, postData, actionUrl, successCallback, errorCallback, completeCallback) {
            if (errorCallback == undefined) {
                errorCallback = function (jqXHR, textStatus, errorThrown) {
                    console.log('ERROR: ' + jqXHR.status);
                };
            }
            if (completeCallback == undefined) {
                completeCallback = function (jqXHR, textStatus) {
                }
            }
            $.ajax({
                type: requestType,
                data: postData,
                url: actionUrl,
                contentType: "application/x-www-form-urlencoded",
                dataType: "json",
                success: eval(successCallback),
                error: eval(errorCallback),
                complete: eval(completeCallback)
            });
        }
    };
}();