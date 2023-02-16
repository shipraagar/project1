@extends(route_prefix().'admin.admin-master')

@section('title') {{__('Other Settings')}} @endsection

@section('style')

@endsection
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">{{__('Other Settings')}}</h4>
                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route(route_prefix().'admin.other.settings')}}">
                    @csrf
                    <x-lang-tab>
                        @foreach(\App\Facades\GlobalLanguage::all_languages() as $lang)
                            <x-slot :name="$lang->slug">

                                @if(get_static_option('tenant_default_theme') == 'donation')
                                    <x-fields.input type="text" value="{{get_static_option('donation_top_campaign_button_'.$lang->slug.'_text')}}" name="donation_top_campaign_button_{{ $lang->slug}}_text" label="{{__('Donation Home Top Button Text')}}"/>
                                    <x-fields.input type="text" value="{{get_static_option('donation_top_campaign_button_'.$lang->slug.'_url')}}" name="donation_top_campaign_button_{{ $lang->slug}}_url" label="{{__('Donation Home Top Button URL')}}" info="{{__('If You have no url then leave this field empty as default')}}"/>
                                @endif

                                @if(get_static_option('tenant_default_theme') == 'event')
                                    <x-fields.input type="text" value="{{get_static_option('event_top_event_button_'.$lang->slug.'_text')}}" name="event_top_event_button_{{ $lang->slug}}_text" label="{{__('Event Home Top Button Text')}}"/>
                                    <x-fields.input type="text" value="{{get_static_option('event_top_event_button_'.$lang->slug.'_url')}}" name="event_top_event_button_{{ $lang->slug}}_url" label="{{__('Event Home Top Button URL')}}" info="{{__('If You have no url then leave this field empty as default')}}"/>
                                @endif

                                @if(get_static_option('tenant_default_theme') == 'job-find')
                                    <x-fields.input type="text" value="{{get_static_option('job_top_job_button_'.$lang->slug.'_text')}}" name="job_top_job_button_{{ $lang->slug}}_text" label="{{__('Job Home Top Button Text')}}"/>
                                    <x-fields.input type="text" value="{{get_static_option('job_top_job_button_'.$lang->slug.'_url')}}" name="job_top_job_button_{{ $lang->slug}}_url" label="{{__('Job Home Top Button URL')}}" info="{{__('If You have no url then leave this field empty as default')}}"/>
                                @endif

                               @if(get_static_option('tenant_default_theme') == 'article-listing')
                                    <x-fields.input type="text" value="{{get_static_option('article_top_job_button_'.$lang->slug.'_text')}}" name="article_top_job_button_{{ $lang->slug}}_text" label="{{__('Article Home Top Button Text')}}"/>
                                    <x-fields.input type="text" value="{{get_static_option('article_top_job_button_'.$lang->slug.'_url')}}" name="article_top_job_button_{{ $lang->slug}}_url" label="{{__('Article Home Top Button URL')}}" info="{{__('If You have no url then leave this field empty as default')}}"/>
                               @endif

                                @if(get_static_option('tenant_default_theme') == 'support-ticketing')
                                    <x-fields.input type="text" value="{{get_static_option('ticket_top_job_button_'.$lang->slug.'_text')}}" name="ticket_top_job_button_{{ $lang->slug}}_text" label="{{__('Ticket Home Top Button Text')}}"/>
                                    <x-fields.input type="text" value="{{get_static_option('ticket_top_job_button_'.$lang->slug.'_url')}}" name="ticket_top_job_button_{{ $lang->slug}}_url" label="{{__('Ticket Home Top Button URL')}}" info="{{__('If You have no url then leave this field empty as default')}}"/>
                                @endif

                                @if(get_static_option('tenant_default_theme') == 'agency')
                                    <x-fields.input type="text" value="{{get_static_option('agency_top_contact_button_'.$lang->slug.'_text')}}" name="agency_top_contact_button_{{ $lang->slug}}_text" label="{{__('Agency Home Top Button Text')}}"/>
                                    <x-fields.input type="text" value="{{get_static_option('agency_top_contact_button_'.$lang->slug.'_url')}}" name="agency_top_contact_button_{{ $lang->slug}}_url" label="{{__('Agency Home Top Button URL')}}"/>
                                @endif


                                @if(get_static_option('tenant_default_theme') == 'newspaper')
                                    <x-fields.input type="text" value="{{get_static_option('news_top_contact_button_'.$lang->slug.'_text')}}" name="news_top_contact_button_{{ $lang->slug}}_text" label="{{__('Newspaper Home Top Button Text')}}"/>
                                    <x-fields.input type="text" value="{{get_static_option('news_top_contact_button_'.$lang->slug.'_url')}}" name="news_top_contact_button_{{ $lang->slug}}_url" label="{{__('Newspaper Home Top Button URL')}}"/>
                                    <x-fields.switcher name="newspaper_top_leftbar" value="{{get_static_option('newspaper_top_leftbar')}}"  label="{{__('Enable/Disable Top Inner Bar')}}"/>
                                @endif

                                @if(get_static_option('tenant_default_theme') == 'construction')
                                    <x-fields.input type="text" value="{{get_static_option('construction_top_contact_button_'.$lang->slug.'_text')}}" name="construction_top_contact_button_{{ $lang->slug}}_text" label="{{__('Construction Home Top Button Text')}}"/>
                                    <x-fields.input type="text" value="{{get_static_option('construction_top_contact_button_'.$lang->slug.'_url')}}" name="construction_top_contact_button_{{ $lang->slug}}_url" label="{{__('Construction Home Top Button URL')}}"/>
                                @endif

                                @if(get_static_option('tenant_default_theme') == 'consultancy')
                                    <x-fields.input type="text" value="{{get_static_option('consultancy_top_contact_button_'.$lang->slug.'_text')}}" name="consultancy_top_contact_button_{{ $lang->slug}}_text" label="{{__('Consultancy Home Top Button Text')}}"/>
                                    <x-fields.input type="text" value="{{get_static_option('consultancy_top_contact_button_'.$lang->slug.'_url')}}" name="consultancy_top_contact_button_{{ $lang->slug}}_url" label="{{__('Consultancy Home Top Button URL')}}"/>
                                @endif


                                @if(get_static_option('tenant_default_theme') == 'eCommerce')
                                    <div class="alert alert-warning mt-5">
                                        {{__('No Settings Available for this theme')}}
                                    </div>
                                @endif

                            </x-slot>
                        @endforeach
                    </x-lang-tab>

                    @if(get_static_option('tenant_default_theme') != 'eCommerce')
                      <button type="submit" class="btn btn-gradient-primary me-2">{{__('Save Changes')}}</button>
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

@endsection
