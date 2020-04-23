<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h5 class="card-title">ЗАЯВКА НА ВЫВОД</h5>

    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-6">

                К выводу доступно <b><?=\APP\core\base\Model::getBal()?></b> рублей <br>
                <hr>

                <div class="form-group">
                    <label>СУММА</label>
                    <input type="text" name="qiwi" placeholder="QIWI" class="form-control">
                </div>

                <div class="form-group">
                    <label>СПОСОБ: <span class="text-danger">*</span> </label>
                    <select data-placeholder="Выберете направление" name="role" class="form-control form-control-select2 required" data-fouc>

                        <option <?= ($_SESSION['ulogin']['role'] == "O") ? 'selected' : ""?> value="O" >Оператор</option>
                        <option <?= ($_SESSION['ulogin']['role'] == "R") ? 'selected' : ""?> value="R" >Рекламодатель</option>
                    </select>

                </div>



                <a href="/panel/cashout/" type="button" class="btn btn-warning"><i class="icon-credit-card mr-2"></i>ЗАКАЗАТЬ ВЫВОД</a>

            </div>



            <form action="/panel/cashout/" method="post">
            <div class="col-md-6">

                <div class="form-group">
                    <label>QIWI</label>
                    <input type="text" name="qiwi" placeholder="QIWI" class="form-control">
                </div>

                <div class="form-group">
                    <label>Яндекс.Деньги</label>
                    <input type="text"  name="yandexmoney"  placeholder="Яндекс.Деньги" class="form-control">
                </div>

                <div class="form-group">
                    <label>Номер карты</label>
                    <input type="text"  name="cardnumber"  placeholder="Номер карты" class="form-control">
                </div>



                <button  type="button" class="btn btn-warning"><i class="icon-checkmark mr-2"></i>СОХРАНИТЬ РЕКВИЗИТЫ</button>




            </div>
            </form>

        </div>





    </div>



</div>
