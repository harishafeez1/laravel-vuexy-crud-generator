namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{{ $data['singular'] }};

class {{ $data['singular'] }}Controller extends Controller
{
    
    public function index(Request $request){
        ${{ $data['singular_lower'] }}  = indexPageTable('{{ $data['plural_lower'] }}', $request);
        return response()->json(${{ $data['singular_lower'] }} );
    }
    
    //view function
    public function view(Request $request, $id){
      return {{ $data['singular'] }}::findOrFail($id);
    }


    public function edit(Request $request, $id){
      ${{ $data['singular_lower'] }} = {{ $data['singular'] }}::findOrFail($id);

      return response()->json(${{ $data['singular_lower'] }});
    }



   //create function    
    public function create(Request $request){
        
      $validatedData = $request->validate([
              
        @foreach($data['fields'] as $field)
        @if($field['required'] && $field['name'] !== 'id')

                '{{ $field['name'] }}' => 'required @if($field['max'])|max:{{$field['max']}} @endif',
        @endif
        @endforeach
        ],[
        @foreach($data['fields'] as $field)
        @if($field['required'] && $field['name'] !== 'id')
                '{{ $field['name'] }}.required' => '{{ $field['name'] }} is a required field.',
        @if($field['max'])
                '{{ $field['name'] }}.max' => '{{ $field['name'] }} can only be {{$field['max']}} characters.',
        @endif
        @endif
        @endforeach
      ]);

        ${{ $data['singular_lower'] }} = {{ $data['singular'] }}::create($request->all());    
        return ['status'=>'success','message'=> 'Record has been updated successfully'];
    }
    
    //update function
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
@foreach($data['fields'] as $field)
@if($field['required'] && $field['name'] !== 'id')
        '{{ $field['name'] }}' => 'required @if($field['max'])|max:{{$field['max']}} @endif',
@endif
@endforeach
      ],[
@foreach($data['fields'] as $field)
@if($field['required'] && $field['name'] !== 'id')
        '{{ $field['name'] }}.required' => '{{ $field['name'] }} is a required field.',
@if($field['max'])
        '{{ $field['name'] }}.max' => '{{ $field['name'] }} can only be {{$field['max']}} characters.',
@endif
@endif
@endforeach
      ]);

        ${{ $data['singular_lower'] }} = {{ $data['singular'] }}::findOrFail($id);
        $input = $request->all();
        ${{ $data['singular_lower'] }}->fill($input)->save();
      return ['status'=>'success','message'=> 'Record has been updated successfully'];
    }
    
    public function delete(Request $request, $id){
        ${{$data['singular_lower']}} = {{$data['singular']}}::findOrFail($id);
        ${{$data['singular_lower']}}->delete();
      return ['status'=>'success','message'=>'Record has been updated successfully'];
    }
}
