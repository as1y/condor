<div class="row">
    <div class="col-md-4">

        <!-- Left aligned buttons -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Форма результата успешного звонка</h6>
            </div>

            <div class="card-body">

                <?php

                $company['formresult'] = '[{"NAME":"ИМЯ","TYPE":1}]';

                $FORMRESULT = json_decode($company['formresult'],TRUE);


//                show($FORMRESULT);

                renderform($FORMRESULT);

                ?>



            </div>


            <div class="card-footer d-flex justify-content-between align-items-center bg-teal-400 border-top-0">
                <span  class="btn bg-transparent text-white border-white border-2">Данная форма обязательна для заполнения оператором</span>
            </div>


        </div>
        <!-- /left aligned buttons -->


    </div>


    <div class="col-md-6">

        <!-- Left aligned buttons -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Редактирование формы результата звонка</h6>

            </div>

            <div class="card-body">


                <table class="table table-bordered ">
                    <tbody><tr>
                        <td><b>ПОЛЕ/ВОПРОС</b></td>
                        <td><b>ТИП ВВОДА</b></td>
                        <td><b>ДОБАВИТЬ</b></td>
                    </tr>

                    <tr>
                        <td><input type="text" class="form-control input-medium" id="NAME" placeholder="Например: Фамилия"></td>

                        <td><select id="TYPE" class="form-control input-small">
                                <option value="1">Текст</option>
                                <option value="2">Дата</option>
                                <option value="3">Текстовое поле</option>
                            </select>
                        </td>


                        <td>
                            <button type="button" class="btn btn-success"><i class="icon-plus3 mr-2"></i></button>

                        </td>


                    </tr>

                    </tbody></table>





            </div>
        </div>
        <!-- /left aligned buttons -->


    </div>




</div>





