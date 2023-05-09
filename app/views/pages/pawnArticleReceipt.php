<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/pawnArticleReceipt.css" />
</head>

<body>
    <div class="print-btn">
        <a href="<?php echo URLROOT ?>/mgPawnArticles/viewPawnedItem/<?php echo $data[0]->Article_Id?>" class="backbtn"><img src="<?php echo URLROOT ?>/img/backbutton.png" alt="back"></a>

        <button id="generate-pdf">Print Me</button>
    </div>
    <div id="print" class="three-boxes">
        <section class="left-box">
            <div class="article-details-topic">Details of Article <?php echo $data[0]->Article_Id ?></div>
            <div class="article-image">
                <img src="<?php if (!empty($data[0]->image)) {
                                echo $data[0]->image;
                            } else {
                                echo URLROOT . "/img/2.png";
                            } ?>" alt="" />
            </div>
            <div class="article-des">
                <div class="article-info">
                    <div class="field-name">Customer ID</div>
                    <div class="field-value"><?php echo $data[0]->userId ?></div>
                </div>
                <div class="article-info">
                    <div class="field-name">Article ID</div>
                    <div class="field-value"><?php echo $data[0]->Article_Id ?></div>
                </div>
                <div class="article-info">
                    <div class="field-name">Pawn ID</div>
                    <div class="field-value"><?php echo $data[0]->Pawn_Id ?></div>
                </div>
                <div class="article-info">
                    <div class="field-name">Loan ID</div>
                    <div class="field-value"><?php echo $data[0]->Loan_Id ?></div>
                </div>
                <div class="article-info">
                    <div class="field-name">Karatage</div>
                    <div class="field-value"><?php echo $data[0]->Karatage ?>K</div>
                </div>
                <div class="article-info">
                    <div class="field-name">Weight</div>
                    <div class="field-value"><?php echo $data[0]->Weight ?>g</div>
                </div>
                <div class="article-info">
                    <div class="field-name">Type</div>
                    <div class="field-value"><?php echo $data[0]->Type ?></div>
                </div>
                <div class="article-info">
                    <div class="field-name">Karatage Price</div>
                    <div class="field-value">Rs. <?php echo $data[0]->Karatage_Price ?>/=</div>
                </div>
                <div class="article-info">
                    <div class="field-name">Loan Interest</div>
                    <div class="field-value"><?php echo $data[0]->Interest ?>%</div>
                </div>
                <div class="article-info">
                    <div class="field-name">Pawned Date</div>
                    <div class="field-value"><?php echo $data[0]->Pawn_Date ?></div>
                </div>
                <div class="article-info">
                    <div class="field-name">Repay Method</div>
                    <div class="field-value"><?php echo $data[0]->Repay_Method ?></div>
                </div>
                <div class="article-info">
                    <div class="field-name">Full Loan Amount</div>
                    <div class="field-value">Rs. <?php echo $data[0]->Estimated_Value ?>/=</div>
                </div>
                <div class="article-info">
                    <div class="field-name">Registerd By</div>
                    <div class="field-value"><?php echo $data[0]->Officer_Id ?></div>
                </div>
                <div class="article-info">
                    <div class="field-name">Validated By</div>
                    <div class="field-value"><?php echo $data[0]->Appraiser_Id ?></div>
                </div>
            </div>

        </section>
        <div class="right-box">
            <section class="top-box-of-right-box">
                <div class="payment-history-topic">Payment History</div>

                <div class="table">
                    <div class="table-section">
                        <?php if (!empty($data[1])) { ?>
                            <table id="myTable">
                                <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <?php if ($data[0]->Repay_Method == 'Fixed') { ?> <th>Installment</th><?php } else { ?><th>Principal</th><?php } ?>
                                        <th>Type</th>
                                        <th>Paid Date/Time</th>
                                        <th>Paid Amount</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($data[1] as $row) { ?>
                                        <tr>
                                            <td><?php echo $row->PID ?></td>
                                            <?php if ($data[0]->Repay_Method == 'Fixed') { ?> <td>Rs. <?php echo $data[0]->monthly_installment ?>/=</td><?php } else { ?><td>Rs. <?php echo $row->Principle_Amount ?>/=</td><?php } ?>
                                            <td><?php echo $row->Type ?></td>
                                            <td><?php echo $row->Date ?></td>
                                            <td>Rs. <?php echo $row->Amount ?>/=</td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div id="tfoot"></div>

                        <?php } else {
                            echo "<p style='display:flex;justify-content:center; margin-top:20px;'>Not Available</P>";
                        } ?>

                    </div>
                </div>
            </section>
            <section class="bottom-box">
                <div class="due-payments-topic">Due Payments</div>

                <div class="amount-and-due-date">
                    <div class="data-field">
                        <div class="field">Paid Amount :</div>
                        <div class="value"><?php if (!empty($data[0])) { ?> Rs.<?php echo $data[2] ?>/=<?php } else echo "Not Available"; ?></div>
                    </div>
                    <div class="data-field">
                        <div class="field">Due Amount:</div>
                        <div class="value"><?php if (!empty($data[0])) { ?> Rs.<?php echo $data[0]->Estimated_Value - $data[2] ?>/=<?php } else echo "Not Available"; ?></div>
                    </div>
                    <div class="data-field">
                        <div class="field">Due Date :</div>
                        <div class="value"><?php echo $data[0]->End_Date ?></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var element = document.getElementById("print");
    var opt = {
        margin: 0,
        filename: "ArticleReport.pdf",
        image: {
            type: "jpeg",
            quality: 0.98,
        },
        html2canvas: {
            scale: 2,
        },
        jsPDF: {
            unit: "in",
            format: "letter",
            orientation: "portrait",
        },

    };

    const generatePdfButton = document.getElementById("generate-pdf");
    generatePdfButton.addEventListener("click", () => {
        // New Promise-based usage:
        html2pdf().set(opt).from(element).save();

        // Old monolithic-style usage:
        html2pdf(element, opt);
    });
</script>

</html>