<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this tag, the sky will fall on your head -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Send Email</title>
	
<link rel="stylesheet" type="text/css" href="<?=base_url()?>appsources/stylesheets/email.css" />

</head>
 
<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#ddd">
	<tr>
		<td></td>
		<td class="header container">			
			<div class="content">
				<table bgcolor="#ddd">
					<tr>
						<td><img style="width:200px"src="<?=base_url()?>appsources/mypouch-color.png" /></td>
					</tr>
				</table>
			</div>				
		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->
<!-- BODY -->
<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">

			<div class="content">
			<table>
				<tr>
					<td>
						
						<h3>Thanks, <?=$name?></h3>
						<p class="lead">Your document has been uploaded for verification, then you will receive an email reply from our system.</p>
						<p class="lead">After you fill the document, please upload to this link :</p>
						<a href="<?=base_url()?>auth/status/<?=$userID?>">Open Link</a>					
						<br/>
						<br/>
					</td>
				</tr>
			</table>
			</div>
									
		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
	<tr>
		<td></td>
		<td class="container">
			
				<!-- content -->
				<div class="content">
				<table>
				<tr>
					<td align="center">
						<p>
							<a href="#">Terms</a> |
							<a href="#">Privacy</a> |
							<a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
						</p>
					</td>
				</tr>
			</table>
				</div><!-- /content -->
				
		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->

</body>
</html>