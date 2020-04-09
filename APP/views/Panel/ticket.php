<div class="row">

    <div class="col-md-6">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">МОИ ТИКЕТЫ</h5>
                <div class="header-elements">
                    <div class="list-icons">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <p class="mb-3">Example of a table placed inside <code>card body</code>. Such tables always have additional whitespace taken from <code>.card-body</code> element padding.</p>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Eugene</td>
                            <td>Kopyov</td>
                            <td>@Kopyov</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Victoria</td>
                            <td>Baker</td>
                            <td>@Vicky</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>James</td>
                            <td>Alexander</td>
                            <td>@Alex</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Franklin</td>
                            <td>Morrison</td>
                            <td>@Frank</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>




    <div class="col-md-6">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">ОТКРЫТЬ ТИКЕТ</h6>
            </div>

            <div class="card-body">
                <form  action="/panel/ticket/" method="post" data-fouc>

                    <div class="form-group">
                        <label>Заголовок тикета: <span class="text-danger">*</span></label>
                        <input type="text" name="zagolovok" class="form-control required" placeholder="Заголовок тикета">
                    </div>

                    <div class="form-group">
                        <label>Текст: <span class="text-danger">*</span></label>
                            <textarea rows="4" cols="4"  name="text" class="form-control required" placeholder="Сообщение"></textarea>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-lg-10 ml-lg-auto text-left">
                            <button type="submit" class="btn bg-success ml-3">ОТКРЫТЬ ТИКЕТ <i class="icon-paperplane ml-2"></i></button>
                            <button type="submit" class="btn btn-light">ОЧИСТИТЬ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



    </div>

</div>