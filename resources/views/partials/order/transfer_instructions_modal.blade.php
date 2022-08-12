<!-- Product Detail Modal -->
<div class="program-modal modal fade" id="TransferInstructionsModal" tabindex="-1" role="dialog" aria-hidden="true"
  data-bs-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="close-modal" data-bs-dismiss="modal"><img src="{{ asset('storage/icons/close-icon.svg') }}"
          alt="Close Modal" />
      </div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="modal-body">
              <h2>Transfer Instructions</h2>

              <h4>Mandiri</h4>

              <p>Bank Mandiri (Automatic Check) can accept transfers from other banks. The following are transfer
                instructions if you use Bank Mandiri.</p>
              <h5>ATM</h5>
              <ol>
                <li>Select Pay/Buy.</li>
                <li>Select More > More > Multi Payment.</li>
                <li>Enter company code xxxx8 and select True.</li>
                <li>Enter the pay code 896 08XXXXXXXX and select Correct.</li>
                <li>Double-check the information on the screen. Make sure the Merchant is Shopee, the total bill is
                  correct, and your username is {username}. If it is correct, press the number 1 (one) and select Yes.
                </li>
                <li>Check the confirmation screen and select Yes.</li>
              </ol>
              <h5>E-Banking</h5>
              <ol>
                <li>Select Pay > Multi Payment.</li>
                <li>Select from Account: Your Account and select Service Provider: Shopee > Continue.</li>
                <li>Enter the pay code 896 08XXXXXXXX > Continue.</li>
                <li>Double-check the information on the screen. Make sure the Merchant is Shopee, the total bill is
                  correct, and your username is {username}. If it is correct,</li>
              </ol>

              <h4>Bank BRI</h4>

              <p>BRI Bank Virtual Accounts only accept transfers from BRI Bank accounts. For payments with a BRI Syariah
                Bank account, use a Bank Mandiri virtual account. The following are transfer instructions if you use
                Bank
                BRI.</p>
              <h5>ATM</h5>
              <ol>
                <li>Select Other Transactions > Payments > Others > select BRIVA.</li>
                <li>Enter no. BRIVA listed on the Payment page (consisting of 3 (three) Bank code numbers + User mobile
                  number/random number) and select True.</li>
                <li>Double-check the information on the screen. Make sure the Merchant is Shopee, the total bill is
                  correct, and your username is {username}. If it is correct, select Yes.</li>
              </ol>
              <h5>E-Banking</h5>
              <ol>
                <li>Select the Payment menu > select BRIVA.</li>
                <li>Select the original account, then select Fill in Pay Code and enter the Pay Code listed on the
                  Payment
                  page (consisting of 3 (three) Bank code numbers + User mobile number/random number) and select Send.
                </li>
                <li>Check the information on the screen. Make sure the Merchant is Shopee, the total bill is correct,
                  and
                  your username is {username}. If it is correct, enter your E-Banking Password and mToken, then select
                  Send.</li>
              </ol>
              <h5>M-Banking</h5>
              <ol>
                <li>Go to BRI Mobile Banking main page > Payment > select BRIVA.</li>
                <li>Enter no. BRIVA listed on the Payment page (consisting of 3 (three) Bank code numbers + User mobile
                  number/random number).</li>
                <li>Enter your PIN > select Send. If a confirmation message appears for transactions using SMS, select
                  OK.
                  Transaction status will be sent via SMS and can be used as proof of payment.</li>
              </ol>
              <h5>Mini ATM/EDC BRI</h5>
              <ol>
                <li>Select Mini ATM > Payment > select BRIVA.</li>
                <li>Swipe your BRI debit card.</li>
                <li>Enter no. BRIVA listed on the Payment page (consisting of 3 (three) Bank code numbers + User mobile
                  number/random number), then select OK.</li>
                <li>Enter your PIN > select OK.</li>
                <li>Double-check the information on the screen. Make sure the Merchant is Shopee, the total bill is
                  correct, and your username is {username}, then select Continue. If the transaction is successful, the
                  proof of the transaction will be printed.</li>
              </ol>

              <h4>BCA</h4>

              <p>Bank BCA virtual accounts only accept transfers from Bank BCA. Here are the transfer instructions if
                you
                use Bank BCA.</p>
              <h5>ATM</h5>
              <ol>
                <li>Select Other Transactions > Transfer > select transfer to BCA Virtual Account.</li>
                <li>Enter no. Virtual Account listed on the Payment page (consisting of 3 (three) Bank code numbers +
                  User
                  mobile number/random number) and select True.</li>
                <li>Check the information shown on the screen again. Make sure the Merchant is Shopee, the total bill is
                  correct, and your username is {username}. If it is correct select Yes.</li>
              </ol>
              <h5>E-Banking/KlikBCA</h5>
              <ol>
                <li>Select Fund Transfer > Transfer to BCA Virtual Account.</li>
                <li>Select Virtual Account and enter no. Virtual Account listed on the Payment page (consisting of 3
                  (three) Bank code numbers + User mobile number/random number) and select Continue.</li>
                <li>Double-check the information on the screen. Make sure the Merchant is Shopee, the total bill is
                  correct, and your username is {username}. If it is correct, select Continue.</li>
                <li>Enter your KeyBCA Response and select Submit.</li>
              </ol>
              <h5>M-Banking/m-BCA</h5>
              <ol>
                <li>Select m-Transfer > BCA Virtual Account.</li>
                <li>Enter no. Virtual Account listed on the Payment page (consisting of 3 (three) Bank code numbers +
                  User
                  mobile number/random number) and select Send.</li>
                <li>Double-check the information on the screen. Make sure the Merchant is Shopee, the total bill is
                  correct, and your username is {username}. If it is correct, select OK.</li>
                <li>Enter your m-BCA PIN and select OK.</li>
                <li>If the notification "Transaction Failed. The nominal exceeds the daily limit”, please repeat the
                  transaction using KlikBCA (E-Banking) or ATM. Transactions with a nominal value of more than Rp.
                  20,000,000 can only be made through KlikBCA (E-Banking) or ATM.</li>
              </ol>

              <h4>Bank BNI</h4>

              <p>The BNI Bank virtual account only accepts transfers from BNI Bank. Payments using a BNI Bank Virtual
                Account are subject to a limit per transaction of IDR 50,000,000. The following are transfer
                instructions if you use Bank BNI.</p>
              <h5>ATM</h5>
              <ol>
                <li>Select Other Menu > Transfer.</li>
                <li>Select the original account type and select Virtual Account Billing.</li>
                <li>Enter no. Virtual Account listed on the Payment page (consisting of 3 (three) Bank code numbers +
                  User mobile number/random number) > select True.</li>
                <li>The bill to be paid will appear on the confirmation screen.</li>
                <li>Double-check the information shown on the screen. Make sure the Merchant is Shopee, the total bill
                  is correct, and your username is {username}. If it is correct, select Yes.</li>
              </ol>
              <h5>E-Banking</h5>
              <ol>
                <li>Select Transfer > Virtual Account Billing.</li>
                <li>Enter no. Virtual Account listed on the Payment page (consisting of 3 (three) Bank code numbers +
                  User mobile number/random number).</li>
                <li>Select Debit Account > Continue.</li>
                <li>The bill to be paid will appear on the confirmation screen.</li>
                <li>Double-check the information shown on the screen. Make sure the Merchant is Shopee, the total bill
                  is correct, and your username is {username}.</li>
                <li>Enter the Token Authentication Code > select Process.</li>
              </ol>
              <h5>M-Banking</h5>
              <ol>
                <li>Select Transfer > Virtual Account Billing.</li>
                <li>Select Debit Account > enter no. Virtual Account listed on the Payment page (consisting of 3 (three)
                  Bank code numbers + User mobile number/random number) on the New Input menu.</li>
                <li>The bill to be paid will appear on the confirmation screen.</li>
                <li>Double-check the information shown on the screen. Make sure the Merchant is Shopee, the total bill
                  is correct, and your username is {username}. If it is correct, enter your Transaction PIN > Continue.
                </li>
              </ol>
              <button class="btn btn-info btn-xl j mt-4 float-end" data-bs-dismiss="modal" type="button">Back to
                Order</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Product Detail Modal -->