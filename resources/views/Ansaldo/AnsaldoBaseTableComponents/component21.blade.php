<div class="row addunit" style="display: none">
    <div class="col-1  mt-3">.</div>
    <div class="col-8  mt-3">
        <form method="post" encType="multipart/form-data" id="un_form" action={{route('un.store')}}>
            {{csrf_field()}}

            <div class="row mt-1">
                <div class="col-4">
                    <select class="form-control isclicked1" name="ID_NN" id="ID_NN" style="width: 200px;font-family: Tahoma;font-size:x-small;display: inline">
                        @foreach($pps as $pp)
                            <option value="{{$pp->ID_NN}}">{{$pp->NIROGAH_NAME}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <input type="text" maxlength="30" class="form-control" id="UNIT_NUMBER"  data-toggle="tooltip" data-placement="right" title="نام واحد" placeholder="نام واحد" name="UNIT_NUMBER" required style="font-family: Tahoma;font-size: x-small;width:100%">
                </div>
                <div class="col-2">
                    <input type="number" max="100" class="form-control" id="unitNumberDigit"  data-toggle="tooltip" data-placement="right" title="شماره واحد" placeholder="شماره واحد" name="unitNumberDigit" required style="font-family: Tahoma;font-size: x-small;width:100%">
                </div>
                <div class="row">
                    <div class="col-2">
                        <input type="hidden" class="form-control" id="ID_UN" name="ID_UN" >
                    </div>
                </div>
                <br>
                <br>


            </div>
            <div class="row mt-1">
                <div class="col-4" style="text-align: right">
                    <button type="submit" class="btn btn-primary" id="btnupdate66" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                        <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                            <table id="un_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                <tr class="bg-primary" style="color: white;font-size:x-small;">
                                    <td>کد</td>
                                    <td>نام واحد نیروگاه</td>
                                    <td>#</td>
                                    <td>#</td>
                                </tr>
                            </table>
                        </div>
                        <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                            <div class="toast-body"><p id="mytoast5" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-3  mt-3">.</div>
</div>
<div class="row usergroup5" style="display: none">
    <div class="col-2"></div>
    <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش اصلاح نام واحد نیروگاه</p></div>
    <div class="col-2"></div>
</div>