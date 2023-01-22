<div class="modal fade" id="myModal12" style="direction: rtl;">
    <div class="modal-dialog modal-lg" style="margin-top: 20px;">
        <div class="modal-content" style="background-color: #b9bbbe">
            <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">جستجو در میان برنامه های ورود و خروج</p></div>
                    <div class="col-6">
                        <div class="row" style="width: 100%">
                            <div class="col-10">.</div>
                            <div class="col-2">
                                <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white;">&times;</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row tarep " style="width: 100%;margin-left: -150px;direction: rtl;height: 330px;">
                {{--<div class="col-1  mt-3"></div>--}}
                <div class="col-12  mt-1" style="margin-right: 10px">
                    <form method="post" encType="multipart/form-data" id="tp_exx_rep_form" action={{route('out2.store')}}>
                        {{csrf_field()}}
                        <div hidden class="row">
                            <div class="col-3 mt-2">
                                <select class="form-control isclicked1" name="ID_NN_REP" id="ID_NN_REP" style="width: 100%;font-family: Tahoma;font-size:small;display: inline">
                                    @foreach($anns as $ann)
                                        <option value="{{$ann->ID_NN}}">{{$ann->NIROGAH_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-4">
                                <select class="form-control isclicked1" name="ID_TG_R" id="ID_TG_R" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                    <option value="0">انتخاب نوع قطعات</option>
                                    @foreach($ghataats as $ghataat)
                                        <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-5">
                                <select class="form-control isclicked1" name="ID_BA_R" id="ID_BA_R" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                    <option value="0">انتخاب مبدا یا مقصد</option>
                                    @foreach($bas as $ba)
                                        <option value="{{$ba->ID_BA }}">{{$ba->BAZSAZ}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >جستجو </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row mylist" style="margin: auto;width:100%;height:202px;direction: rtl;margin-top: 12px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                    <div class="col-12" style="direction: rtl;height: 200px;overflow-y: scroll">
                                        <table id="eex_table_report" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                            <tr class="bg-primary" style="color: white;font-size:x-small;">
                                                <td>کد</td>
                                                <td>نام شرکت</td>
                                                <td>#</td>
                                                <td>#</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    {{--<div  style="text-align: center;margin-top: 15px">--}}
                    <button class="btn btn-primary" id="confirm5" style="font-family: Tahoma;font-size: small;text-align: center;width:30%;margin-top: 15px" >تایید مورد انتخاب شده</button>
                    {{--</div>--}}
                </div>

            </div>

            <!-- Modal footer -->
            {{--<div class="modal-footer bg-info" style="height: 20px">--}}

        </div>

    </div>
</div>

</div>
