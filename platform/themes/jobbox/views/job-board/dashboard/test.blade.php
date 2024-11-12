@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

@section('content')
    <div>
        <h3 class="mt-0 mb-15 color-brand-1"> Verification Page</h3>
        
        @if(isset($credits))
            <p>Credits: {{ $credits }}</p>
        @endif

        
        {!! Form::open(['route' => 'public.account.test', 'method' => 'POST', 'files' => true]) !!}
        
        <div class="row form-contact">
            <div class="col-lg-12 col-md-12">
                
                
                @if ($account->verified == "requested")
                    <div class="text-success mt-2">You have requested for verification.</div>
                
                @elseif ($account->verified == "yes")
                    <div class="text-success mt-2">You are verified!</div>    
                    
                @else
                    <div class="text-danger mt-2">You are not verified.</div>
                    <br>
        
                    <div class="form-group">
                      <label class="font-sm color-text-mutted mb-10" for="verified">{{ __('Get Verified') }}</label>
                      
                      
                      <select class="form-control @error('verified') is-invalid @enderror" id="verified" name="verified" required>
                            <option value="">--Select--</option>
                            <option value="requested" @if(old('verified', $account->verified) === 'requested') selected @endif>Requested</option>
                            <option value="no" @if(old('verified', $account->verified) === 'no') selected @endif>No</option>
                        </select>
    
                      
                      
                      @error('verified')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                    </div>
                    <div class="border-bottom pt-10 pb-10 mb-30"></div>
                    <div class="box-button mt-15">
                        <button class="btn btn-apply-big font-md font-bold">{{ __('Submit Request') }}</button>
                    </div>
                @endif
                
                
                

                
                
            </div>
          
        </div>
  {!! Form::close() !!}
@stop
