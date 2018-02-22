<div class="row">
    <div class="col s12 input-field">
        <i class="material-icons prefix">account_circle</i>
        {!! Form::label('full_name') !!}
        {!! Form::text('full_name') !!}
    </div>
</div>
<div class="row">
    <div class="col s12 input-field">
        <i class="material-icons prefix">email</i>                    
        {!! Form::label('email') !!}
        {!! Form::text('email') !!}
    </div>
</div>
<div class="row">
    <div class="col s12">
        <i class="fa fa-2x fa-transgender prefix"></i> 
        {!! Form::radio('gender', 'male', null, ['id' => 'male', 'checked' => 'true']) !!}
        {!! Form::label('male') !!}                     
        {!! Form::radio('gender', 'female', null, ['id' => 'female']) !!}       
        {!! Form::label('female') !!}
    </div>
</div>

<div class="row">
    <?php
        $department_list = [];
        foreach(App\Department::all() as $department){
            $department_list[$department->id] = $department->name;
        }
        ?>
    <div class="col s12 input-field">
        <i class="fa fa-2x fa-graduation-cap prefix"></i>                     
        {!! Form::select('department_id', $department_list) !!}
    </div>
</div>
<div class="row">
    <?php
        $college_list = [];
        foreach(App\Year::all() as $year){
            $year_list[$year->id] = $year->name;
        }
        ?>
    <div class="col s12 input-field">
        <i class="fa fa-2x fa-graduation-cap prefix"></i>                     
        {!! Form::select('year_id', $year_list) !!}
    </div>
</div>
<div class="row">
    <?php
        $section_list = [];
        foreach(App\Section::all() as $section){
            $section_list[$section->id] = $section->name;
        }
        ?>
    <div class="col s12 input-field">
        <i class="fa fa-2x fa-graduation-cap prefix"></i>                     
        {!! Form::select('section_id', $section_list) !!}
    </div>
</div>
<div class="row">
    <div class="col s12 input-field">
        {!! Form::submit('Submit', ['class' => 'btn waves-effect waves-light green']) !!}
    </div>
</div>