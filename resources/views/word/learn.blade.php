@extends('layouts.app')

@section('content')
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <section class="app_progress">

               <div class="panel panel-default">
                  <div class="panel-heading"  style="display: flex; justify-content: space-between;">
                     <div>Words learnt (practiced more than 5 times)</div>
                     <div>Level: <b>{{$levelData['level']}}</b></div>
                  </div>
                  <div style="margin: 0 10px 0 10px;">
                     <div class="progress_data" style="display: flex; justify-content: space-between;">
                        <div>{{$levelData['current']}}</div>
                        <div>{{$levelData['next']}}</div>
                     </div>
                     <div>
                        <progress style="width: 100%"
                                max="{{$levelData['next']}}" value="{{$levelData['current']}}"></progress>
                     </div>
                  </div>
               </div>

            </section>
            <section class="app_learn">
               <div class="panel panel-default">
                  <div class="panel-heading">Current words</div>
               <learnBlock></learnBlock>
               </div>
            </section>
         </div>
      </div>
   </div>
@endsection
