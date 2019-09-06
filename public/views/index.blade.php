

<div  ng-app="myApp" id="content" ng-controller="indexController" class="m-5">


    <div class="text-center mb-5"> <button id="button" class=" btn btn-primary ">تحميل كشف الدفعات</button></div>

    <div id="form">
        <div class="alert alert-danger" ng-if="errors.length > 0"  class="close" data-dismiss="alert" aria-label="Close">

            <div ng-repeat="error in errors"><i class="material-icons">close</i> {{ error }}</div>

        </div>

        <div class="container-fluid" style="text-align:right">
            <fieldset class="border" style="width: 70%;margin: auto">
                <legend class="w-auto text-right mr-5 text-primary">  كشف الدفعات   </legend>
                <form  method="post" style="text-align: right;" enctype="multipart/form-data" >
                    <div class="m-4">
                        <label class="ml-5 font-weight-bold"> الملف</label>
                        <input type="file" name="uploadFile" id="uploadFile" ng-model="uploadFile" accept="file" />

                        <button ng-click="chooseFile()" type="submit" id="download" class=" btn btn-danger">تحميل</button>
                    </div>

                </form>
            </fieldset>
        </div>
    </div>


</div>


<script>
    $(document).ready(function () {
        $("#form").hide();


        $('#button').click(function () {
            $("#form").show();
        });
    })

</script>
