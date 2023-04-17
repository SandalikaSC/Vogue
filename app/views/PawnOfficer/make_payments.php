<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="<?php echo URLROOT?>/img/logo_1.png">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles_make_payments.css">
    <title>Vogue Pawn | Make Payments</title>
</head>

<body>     
    <div class="wrapper">
        <div class="header">
            <div class="title">
                <a href="<?php echo URLROOT; ?>/pawnings/payment_details/<?php echo $data['pawn_item']->Pawn_Id; ?>">
                    <img src="<?php echo URLROOT . '/img/back-arrow.png'; ?>">
                </a>
                
                <h1>Make Payments</h1>
            </div>
            
            <div class="logo">
                <img src="<?php echo URLROOT . '/img/logo_name.png'; ?>">
            </div>
        </div>

        <main>
            <div class="main-div-container">
                <div class="left-wrapper">
                    <div class="div-article-details">
                        <div class="div-img">
                            <img src="<?php echo URLROOT . '/img/1.png'; ?>" alt="article image">
                        </div>
                        <div class="div-details">
                            <div class="field-container">
                                <label>ARTICLE ID</label>
                                <div><?php echo $data['pawn_item']->Article_Id; ?></div>
                            </div>
                            <div class="field-container">
                                <label>CUSTOMER ID</label>
                                <div><?php echo $data['pawn_item']->userId; ?></div>
                            </div>
                            <div class="field-container">
                                <label>PAWNED DATE</label>
                                <div><?php echo date('Y-m-d', strtotime($data['pawn_item']->Pawn_Date)); ?></div>
                            </div>
                            <div class="field-container">
                                <label>END DATE</label>
                                <div><?php echo $data['pawn_item']->End_Date; ?></div>
                            </div>
                        </div>

                        <div class="loan-details">
                            <label>Full Loan Amount</label>
                            <div class="amount"><?php echo 'Rs. ' . $data['pawn_item']->Amount; ?></div>
                        </div>
                        <div class="loan-details">
                            <label>Remaining Loan Amount</label>
                            <div class="amount"><?php echo 'Rs. 92000.00'; ?></div>
                        </div>
                        
                    </div>
                </div>
                

                <div class="right-wrapper">
                    <div class="new-payment">
                        <div class="div-form-title">
                            <h2>Payment Details</h2>
                        </div>
                        
                        <form action="" method="post">
                            <div class="field-wrapper">
                                <label>Amount (Rs.)<sup>*</sup></label>
                                <div class="input-wrapper">
                                    <input type="text" name="amount" placeholder="Amount">
                                </div>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="field-wrapper">
                                <label>Date<sup>*</sup></label>
                                <div class="input-wrapper">
                                    <input type="date" name="date">
                                </div>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="field-wrapper">
                                <label>Fine (Rs.)</label>
                                <div class="input-wrapper">
                                    <input type="text" name="fine" placeholder="Fine">
                                </div>
                                <span class="invalid-feedback"></span>
                            </div>
                            
                            <div class="field-wrapper">
                                <input type="submit" class="btn-save" name="save" value="Save">
                            </div>
                        </form>
                    </div>
                </div>

                
            </div>
            
            

            <!-- <div class="main-wrapper">
                <div class="left-wrapper">   
                    <div class="div-details">
                        <div class="article-details">
                            <h2>Article Details</h2>
                            <div class="article-image">
                                <img src="<?php echo URLROOT . '/img/bracelet_01.jpg'; ?>" alt="">
                            </div>
                            <div class="field-wrapper">
                                <div class="field-container">
                                    <label>Article ID</label>
                                    <div><?php echo $data['pawn_item']->Article_Id; ?></div>
                                </div>
                                <div class="field-container">
                                    <label>Customer ID</label>
                                    <div><?php echo $data['pawn_item']->userId; ?></div>
                                </div>
                                <div class="field-container">
                                    <label>Pawned Date</label>
                                    <div><?php echo date('Y-m-d', strtotime($data['pawn_item']->Pawn_Date)); ?></div>
                                </div>
                                <div class="field-container">
                                    <label>End Date</label>
                                    <div><?php echo $data['pawn_item']->End_Date; ?></div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="due-payment">       
                            <h2>Due Payments</h2>             
                            <div>
                                <label>Full Loan Amount</label>
                                <div class="amount"><?php echo 'Rs. ' . $data['pawn_item']->Amount; ?></div>
                            </div>
                            <div>
                                <label>Remaining Loan Amount</label>
                                <div class="amount"><?php echo 'Rs. 92000.00'; ?></div>
                            </div>
                        </div> 
                    </div>                                  
                </div>

                <div class="right-wrapper">
                    <div class="form-wrapper">
                        <div class="div-form">
                            <div class="form-title">
                                <h2>Payment Details</h2>
                            </div>
                        
                            <form action="" method="post">
                                <div class="field-wrapper">
                                    <label>Amount<sup>*</sup></label>
                                    <div class="input-wrapper">
                                        <input type="text" name="amount" placeholder="Amount">
                                    </div>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="field-wrapper">
                                    <label>Date<sup>*</sup></label>
                                    <div class="input-wrapper">
                                        <input type="date" name="date">
                                    </div>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="field-wrapper">
                                    <label>Fine</label>
                                    <div class="input-wrapper">
                                        <input type="text" name="fine" placeholder="Fine">
                                    </div>
                                    <span class="invalid-feedback"></span>
                                </div>
                                
                                <div class="field-wrapper">
                                    <a href="" class="btn-save">Save</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> -->
            
        </main>        
    </div>
    
    <script type="text/javascript">
        
    </script>

</body>
</html>