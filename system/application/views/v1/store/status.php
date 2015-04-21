<div class="container">
	<div style="height:10px;"></div>   
    		<div class="page-content">
            <?php if($result == "success") { ?>
            <h2>Order Status</h2>
                
                <div class="msg"><h4 class="success">Success</h4>
                
                    <p>Congratulations <b><?php 
					$user = $this->session->userdata('userloggedin'); 
					$customer = $this->Customer_model->identify($user['customer_id']); print $customer['firstname']; ?></b> your order has gone through sucsessfully and your products are in the process of being delivered. A payment reciept for order number <b><?php printf('%04d',$this->session->userdata('order_id')); ?></b> has been sent to your email address.</p>
                </div>
                
            </div>
            <?php 
			} else
			{?>
            <div class="page-content">
            <h2>Order Status</h2>
                
                <div class="msg"><h4 class="success">Failed
                <br />
                <?=$this->session->userdata('response')?>
                </h4>
                
                    <p>Sorry, <b><?php 
					$user = $this->session->userdata('userloggedin'); 
					$customer = $this->Customer_model->identify($user['customer_id']); 
					
					print $customer['firstname']; ?></b> your order has gone through unsucsessfully. Please, try again Sorry for inconvenience.</p>
                </div>
                
            </div>
            
            <?
			}
			 ?>                
        
</div>