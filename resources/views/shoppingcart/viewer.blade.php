@extends('layouts.mazer-admin')
@section('heading')
    Resumen de liquidación
@endsection
@section('content')

    <section id="content-types">
        <div class="card-header mt-2 mb-2">
            <div class="buttons">
                <a href="{{ route('admin.deuda.index') }}" class="btn btn-danger"><i class="cart-plus"></i> Regresar</a>
            </div>
        </div>

        <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Liquidación</h4>
                    <p class="card-text">
                        
                    </p>

                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0 ms-3">Nro. de liquidación</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-0">{{ session::get('liquidacion') }}</h5>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0 ms-3">Importe</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-0">S/ {{ session::get('importe') }}</h5>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0 ms-3">Términos y Condiciones</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="termsConditions" checked="">
                                <label class="form-check-label" for="termsConditions">
                                    Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#terminos-condiciones">términos y condiciones</a>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0 ms-3">Políticas de Devolución</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="returnPolicy" checked="">
                                <label class="form-check-label" for="returnPolicy">
                                    Acepto las <a href="" data-bs-toggle="modal" data-bs-target="#politicas-devolucion">políticas de devolución</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Terms and Conditions -->
                    <div class="modal fade text-left" id="terminos-condiciones" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel1">Términos y Condiciones</h5>
                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Este servicio le permitirá al contribuyente realizar el pago de sus tributos y obligaciones administrativas sin necesidad de hacer filas, sin perder tiempo y desde la comodidad de su domicilio o lugar de trabajo.</p>

                                    <p>La intención es facilitar los trámites al contribuyente, de manera que no tenga que acudir a las Oficinas de la Municipalidad, y pueda interactuar con el Municipio de manera sencilla, rápida y sin tener que moverse de su lugar.</p>

                                    <p>Para acceder a este servicio el contribuyente deberá contar con una tarjeta de crédito o de debito afiliada a VISA. Para que se puedan realizar los pagos en línea, la Municipalidad de San Miguel ha desarrollado un Sistema de Pagos que garantiza y respalda las operaciones que pueda realizar.</p>

                                    <p>Una vez que el contribuyente decide hacer el pago vía Internet, el cargo a su tarjeta de crédito o débito se hará en el momento en que se selecciona el botón "Pagar", posteriormente aparecerá una pantalla de información en la cual se podrá visualizar el resultado de la operación.
                                    </p>
                                </div>
                                <div class="modal-footer">                        
                                    <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Aceptar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Return Policy -->
                    <div class="modal fade text-left" id="politicas-devolucion" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel1">Políticas</h5>
                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <b>Políticas de Cancelación </b>
                                    <p>Una vez confirmado el pedido (al seleccionar el botón Pagar) no hay opción a cancelarlo, en tal sentido es necesario que antes de generar el pago verifique bien toda la información.</p>

                                    <p>La Municipalidad de San Miguel no realizará devoluciones de dinero que le corresponda al contribuyente, pero si podrá solicitar Compensaciones y/o Transferencias de acuerdo al Art. 40 Código Tributario D.S. Nº 135-99-EF del 19.08.99.</p>

                                    <b>Procedimiento para solicitar Transferencia y/o Compensación</b>

                                    <li>Acercarse a la Municipalidad de San Miguel a la Gerencia de Administración Tributaria.</li>
                                    <li>En la Sub-Gerencia de Control y Recaudación, le entregarán una Solicitud dirigida al Señor Alcalde en la cual usted deberá indicar el tributo y período materia de Transferencia y/o Compensación.</li>
                                    <li>Y la transferencia se realiza en ese mismo momento</li>
                                    <li>El trámite es gratuito.</li>
                                    <li>Tiempo.</li>
                                    <p>La Solicitud de Compensación y/o transferencia deberá ser presentada en un lapso de tiempo menor al establecido en el Art. 43º y 44º del Código Tributario, pasado este tiempo no hay lugar a reclamo.</p>
                                </div>
                                <div class="modal-footer">                        
                                    <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Aceptar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
              </div>
            </div>
          <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.visa.post_visa')}}" id="payment-form">
                      {{ csrf_field() }}
                      <input type="hidden" name="token_id" id="token_id">
                      <input type="hidden" name="div_session_id" id="div_session_id">
                        <div class="pymnt-itm card active">
                            <div class="pymnt-cntnt">
                                <div class='method-card' id='method-card'>
                                  <div class='method-card__images'>
                                    <img src="{{ asset('images/visa.svg') }}" alt="visa">
                                    <img src="{{ asset('images/mastercard.svg') }}" alt="mastercard">
                                    <img src="{{ asset('images/american-express.svg') }}" alt="american-express">
                                    <img src="{{ asset('images/diners.svg') }}" alt="diners">
                                  </div>
                                  <p class='method-card__description'>
                                    Recuerda que algunas tarjetas cuentan con el código de seguridad o CVV Dinámico,
                                    consúltalo desde el App de tu banco.
                                  </p>
                                  <div class='method-card__inputs'>
                                    <input type="text" placeholder='Nombre del Titular' autocomplete="off" data-openpay-card="holder_name">
                                    <input type="text" placeholder='Número de la Tarjeta' data-openpay-card="card_number">
                                    <input type="text" placeholder='Fecha de Expiración MM' data-openpay-card="expiration_month">
                                    <input type="text" placeholder='Fecha de Expiración AA' data-openpay-card="expiration_year">
                                    <input type="text" placeholder='Código de seguridad' data-openpay-card="cvv2">
                                  </div>
                                  <br>
                                  <button id="_PAGAR" type="button" class='method-card__button' onclick="pagar(event)">
                                    Pagar
                                  </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Toast Notification Container -->
                    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
                        <div id="validation-toast" class="toast border border-primary" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto">Notificación</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                <!-- Mensaje de Validación -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>

    </section>
    
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>

    <script src="https://js.openpay.pe/openpay.v1.min.js"></script>
    <script src="https://js.openpay.pe/openpay-data.v1.min.js"></script>

    <!-- <script src="{{ asset('extensions/OpenPay/openpay.v1.min.js') }} "></script>
    <script src="{{ asset('extensions/OpenPay/openpay-data.v1.min.js') }} "></script> -->

    <script type="text/javascript">
        var merchantId = "{{ config('constants.OPENPAY_KEY_ID') }}"; // COLOCA TU ID
        var pubkey = "{{ config('constants.OPENPAY_KEY_PUBLIC') }}"; // COLOCA TU CLAVE PUBLICA
        OpenPay.setId(merchantId);
        OpenPay.setApiKey(pubkey);
        OpenPay.setSandboxMode(true);
        var div_session_id = OpenPay.deviceData.setup('payment-form','deviceIdHiddenFieldName'); //DEVICE_SESSION_ID
        document.getElementById('div_session_id').value = div_session_id;
        console.log(div_session_id);

        function pagar(event) {
            event.preventDefault();

            if (validarInputs())
            {
                var boton = document.getElementById('_PAGAR');
                boton.disabled = true;
                boton.innerText = 'Procesando...';

                /*document.getElementById('_PAGAR').disabled = true;
                document.getElementById('_PAGAR').innerText = 'Procesando...';*/

                OpenPay.token.extractFormAndCreate('payment-form', function (response) {
                    if (response && response.data && response.data.id) {
                        var token_id = response.data.id; // TOKEN_ID
                        document.getElementById("token_id").value = token_id;
                        document.getElementById("payment-form").submit();
                    } else {
                        console.error("Error: No se pudo obtener el token_id del response");
                    }
                }, function (response) {
                    var content = '';

                    content += 'Estatus del error: ' + response.data.status + '<br />';
                    content += 'Error: ' + response.message + '<br />';
                    content += 'Descripción: ' + response.data.description + '<br />';

                    showToast(content)
                });
            }
        }

        function validarInputs() {
            var holderName = document.querySelector('input[data-openpay-card="holder_name"]').value.trim();
            var cardNumber = document.querySelector('input[data-openpay-card="card_number"]').value.trim();
            var expirationMonth = document.querySelector('input[data-openpay-card="expiration_month"]').value.trim();
            var expirationYear = document.querySelector('input[data-openpay-card="expiration_year"]').value.trim();
            var cvv2 = document.querySelector('input[data-openpay-card="cvv2"]').value.trim();

            var opCardNumber = OpenPay.card.validateCardNumber(cardNumber);
            var opCVC = OpenPay.card.validateCVC(cvv2, cardNumber);
            var opExpiry = OpenPay.card.validateExpiry(expirationMonth, expirationYear);
            var opType = OpenPay.card.cardType(cardNumber);

            if (!holderName) {
                showToast("El nombre del titular es obligatorio.");
                return false;
            }

            if (!opCardNumber) {
                showToast("Tarjeta no Valida");
                return false;
            }

            if (!opExpiry) {
                showToast("Fecha de expiración no Valida");
                return false;
            }

            if (!opCVC) {
                showToast("Código CVC no Valida");
                return false;
            }

            if (!opType) {
                showToast("Tipo de tarjeta no Valida");
                return false;
            }            

            return true;
        }

        function showToast(message) {
            var toastEl = document.getElementById('validation-toast');
            var toastBody = toastEl.querySelector('.toast-body');
            toastBody.textContent = message;

            var toast = new bootstrap.Toast(toastEl, {
                delay: 5000, // 5 seconds
                autohide: true
            });

            toast.show();
        }

    </script>

    <style>
        .main-container {
          max-width: 1200px;
          width: 100%;
          margin: 0 auto;
          position: absolute;
          left: 50%;
          top: 50%;
          transform: translate(-50%, -50%);
        }

        .main-description {
          color: #004080;
          margin-bottom: 40px;
        }

        .main-description span {
          font-weight: 600;
        }

        .payment-methods {
          display: grid;
          grid-template-columns: 1fr 1fr 1fr; 
          grid-gap: 40px;
          margin-bottom: 32px;
        }

        .payment-methods__method {
          background-color: #EAF6FE;
          border: 4px solid #EAF6FE;
          border-radius: 16px;
          padding: 64px 32px;
          display: flex;
          flex-direction: column;
          align-items: center;
          cursor: pointer;
        }

        .payment-methods__method--selected {
          border-color: #004481;
        }

        .payment-methods__method img {
          width: 100%;
          max-width: 180px;
          height: 120px;
          margin-bottom: 32px;
        }

        .payment-methods__method span {
          font-weight: 600;
          text-align: center;
          color: #004080;
        }


        .method-card {
          border-radius: 16px;
          border: 1px solid #989898;
          display: flex;
          flex-direction: column;
          padding: 80px 32px 40px;
        }

        .method-card__images {
          width: 100%;
          max-width: 998px;
          margin: 0 auto;
          display: flex;
          flex-wrap: wrap;
          justify-content: center;
        }

        .method-card__images img {
          margin: 16px;
        }

        .method-card__description {
          color: #004080;
          margin: 24px auto;
        }

        .method-card__inputs {
          display: grid;
          grid-template-columns: 1fr 1fr;
          grid-gap: 16px;
        }

        .method-card__inputs input {
          height: 64px;
          border-radius: 8px;
          border: 0.816px solid #989898;
          padding: 0 16px;
          font-size: 16px;
        }

        .method-card__inputs input::placeholder {
          color: #B1B1B1;
          font-size: 16px;
          text-align: center;
        }

        .method-card__inputs select {
          height: 64px;
          border-radius: 8px;
          border: 0.816px solid #989898;
          padding: 0 16px;
          font-size: 16px;
        }

        .method-card__description span {
          font-weight: bold;
        }

        .method-card__button {
          margin-left: auto;
          cursor: pointer;
          background-color: #004481;
          font-weight: bold;
          color: #FFF;
          border: none;
          padding: 8px 24px;
          border-radius: 8px;
          font-size: 18px;
        }

        .method-digital {
          border-radius: 16px;
          border: 1px solid #989898;
          display: flex;
          flex-direction: column;
          padding: 80px 32px 40px;
          min-height: 500px;
        }

        .method-digital__images {
          width: 100%;
          max-width: 998px;
          margin: 0 auto;
          display: flex;
          flex-wrap: wrap;
          justify-content: center;
        }

        .method-digital__images img {
          margin: 16px;
        }

        .method-digital__description {
          color: #004080;
          margin: 64px auto 56px;
          max-width: 640px;
          text-align: center;
        }

        .method-digital__description span {
          font-weight: bold;
        }

        .method-digital__button {
          margin-left: auto;
          cursor: pointer;
          background-color: #004481;
          font-weight: bold;
          color: #FFF;
          border: none;
          padding: 8px 24px;
          border-radius: 8px;
          font-size: 18px;
        }
    </style>

@endsection