<?php //$permissions->setConditions(5,6,7,8,9)->handle(GetBaseURL()); ?>

<?php
       $id = isset ( $_GET [ "caseID" ] ) ? $_GET [ "caseID" ] : null ;
       $case = GetCaseByID ( $id ) ;
       echo load_tipsy ( ) ;
?>
<script type="text/javascript">
       $(document).ready(function(){
              $('.case-attachment-img').hover(function() {
                     $(this).stop().animate({ opacity: 0.3 }, 800);
              },function() {
                     $(this).stop().animate({ opacity: 1.0 }, 800);
              });
              $('.case-attachment-img').tipsy({
                     fallback : '<font face="Open Sans" size="2">Remove this attachment.</font>',
                     html: true,
                     fade: true,
                     gravity: 's'
              });
              $('.case-attachment-img').click(function(e){
                     var $this = $(this);
                     var imageSource = $this.attr('src');
                     var attachID = $this.attr('id');
                     $.ajax({
                            type: 'POST',
                            data: {
                                  src : imageSource ,
                                  action : 'delete' ,
                                  id : attachID 
                            },
                            url: '<?php echo BaseURLConcat ( 'Actions/delete-case-attachment.php' ) ?>',
                            success: function ( data ) {
                                   if ( data == "true" ) {
                                          $this.slideUp('slow', function(){});
                                          if($('.case-attachment-img').size() == 0){
                                                 $('#attachments-mrg').slideUp('slow');
                                          }
                                   } else $this.fadeOut('slow', function(){
                                          $(this).fadeIn('fast', function(){});
                                   });
                            }
                     });
                     e.preventDefault();
                     return false;
              });
       });
</script>
<form method="POST">
       <table border="0" cellpadding="4" cellspacing="1">
              <tr>
                     <td align="right">Title</td>
                     <td><input type="text" name="title" id="title" value="<?php echo $case [ 'title' ] ?>" size="50" /></td>
              </tr>
              <tr>
                     <td align="right">Priority</td>
                     <td>
                            <select name="priority" id="priority">
                                   <option value="Normal" <?php echo Selected ( $case [ 'priority' ] , 'Normal' ) ?>>Normal</option>
                                   <option value="Moderate" <?php echo Selected ( $case [ 'priority' ] , 'Moderate' ) ?>>Moderate</option>
                                   <option value="High" <?php echo Selected ( $case [ 'priority' ] , 'High' ) ?>>High</option>
                            </select>
                     </td>
              </tr>
              <tr>
                     <td align="right">Reason</td>
                     <td>
                            <select name="reason" id="reason">
                                   <option value="">-- Select --</option>
                                   <optgroup label="Game">
                                          <option value="Bugs" <?php echo Selected ( $case [ 'reason' ] , 'Bugs' ) ?>>Bugs</option>
                                          <option value="Hacked" <?php echo Selected ( $case [ 'reason' ] , 'Hacked' ) ?>>Hacked</option>
                                          <option value="Need information" <?php echo Selected ( $case [ 'reason' ] , 'Need information' ) ?>>Need information</option>
                                          <option value="Account Banned" <?php echo Selected ( $case [ 'reason' ] , 'Account Banned' ) ?>>Account Banned</option>
                                   </optgroup>
                                   <optgroup label="Players">
                                          <option value="Players Problems" <?php echo Selected ( $case [ 'reason' ] , 'Players Problems' ) ?>>Players Problems</option>
                                          <option value="Offenses" <?php echo Selected ( $case [ 'reason' ] , 'Offenses' ) ?>>Offenses</option>
                                          <option value="Other Related" <?php echo Selected ( $case [ 'reason' ] , 'Other Related' ) ?>>Other Related</option>
                                   </optgroup>
                                   <optgroup label="Systems">
                                          <option value="Gift System" <?php echo Selected ( $case [ 'reason' ] , 'Gift System' ) ?>>Gift System</option>
                                          <option value="Donate System" <?php echo Selected ( $case [ 'reason' ] , 'Donate System' ) ?>>Donate System</option>
                                          <option value="Payment Related" <?php echo Selected ( $case [ 'reason' ] , 'Payment Related' ) ?>>Payment Related</option>
                                   </optgroup>
                                   <option value="Others" <?php echo Selected ( $case [ 'reason' ] , 'Others' ) ?>>Others</option>
                            </select>
                     </td>
              </tr>
              <tr>
                     <td align="right">Description</td>
                     <td><textarea name="description" id="description" cols="50" rows="5"><?php echo $case [ 'content' ] ?></textarea></td>
              </tr>
              <?php $attachments = GetCaseAttachments ( $id ) ; ?>
              <?php if ( count ( $attachments ) >= 1 ) : ?>
              <tr>
                     <td align="right">Attachments</td>
                     <td class="attachments-mrg">
                            <?php 
                                   foreach ( $attachments as $caseAttachment ) {
                                          echo '<img src="', BaseURLConcat ( CaseAttachmentThumb ( $caseAttachment [ 'attachment' ] ) ) ,'" id="', $caseAttachment [ 'aid' ] ,'" class="case-attachment-img" /> ' ;
                                   }
                            ?>
                     </td>
              </tr>
              <?php endif ; ?>
              <tr>
                     <td></td>
                     <td><input type="submit" name="update" value="Update Case" /></td>
              </tr>
       </table>
</form>
<?php 
       if ( isset ( $_SESSION [ "$.response.message" ] ) ) {
              echo $_SESSION [ "$.response.message" ] ;
              $_case = GetCaseByID ( $id ) ;
              AddNotifyToAccountCharacters ( $_case [ 'creatorAccountID' ] , strftime ( 'His case was updated at %H:%M' , time ( ) ) ) ;
              unset ( $_SESSION [ "$.response.message" ] ) ;
       }
       if ( isset ( $_POST [ "update" ] ) ) {
              $title = $_POST [ "title" ] ;
              $reason = $_POST [ "reason" ] ;
              $description = $_POST [ "description" ] ;
              $priority = $_POST [ "priority" ] ;
              if ( IsEmpty ( $title ) ) {
                     echo '<span class="inline-help">The title of the case cannot be empty.</span>' ;
              } elseif ( ! MatchLength ( 8 , 60 , $title ) ) {
                     echo '<span class="inline-help">The title must contain 8 - 60 characters.</span>' ;
              } elseif ( IsEmpty ( $reason ) ) {
                     echo '<span class="inline-help">You should report the new reaction to the case.</span>' ;
              } elseif ( IsEmpty ( $description ) ) {
                     echo '<span class="inline-help">You should describe the case.</span>' ;
              } else {
                     $accountid = GetLoggedAccountID ( ) ;
                     $db = Connection ( 'db_misc' ) ;
                     $case = $db->prepare ( 'UPDATE t_cases SET title = ? , content = ? , reason = ? , priority = ? WHERE cid = ?' ) ;
                     $case->bindValue ( 1 , $title , PDO::PARAM_STR ) ;
                     $case->bindValue ( 2 , $description , PDO::PARAM_STR ) ;
                     $case->bindValue ( 3 , $reason , PDO::PARAM_STR ) ;
                     $case->bindValue ( 4 , $priority , PDO::PARAM_STR ) ;
                     $case->bindValue ( 5 , CaseID ( $id ) , PDO::PARAM_INT ) ;
                     $case->execute ( ) ;
                     if ( $case->execute ( ) ) {
                            $message = null ;
                            $message .= '<span class="inline-info"> ';
                            $message .= 'Case updated successfully.' ;
                            $message .= '</span>' ;
                            $_SESSION [ '$.response.message' ] = $message ;
                            header ( 'Location: ' . BaseURLConcat ( 'panel/caseManagement/caseID/' . $id ) ) ;
                     }
              }
       }
?>