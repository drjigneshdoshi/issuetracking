<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		
		  					 <? if(IsAdministrator()):?>
				 		window.location.href = "home";
                      <? endif; ?>	
                      <? if(IsUser()):?>
                      		window.location.href = "CreateCase";
                      <? endif; ?>

	</script>
</head>
<body>

</body>
</html>