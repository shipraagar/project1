<?php


namespace Modules\Event\Helpers\DataTableHelpers;


use App\Enums\DonationPaymentStatusEnum;
use App\Enums\StatusEnums;
use App\Facades\GlobalLanguage;
use Modules\Donation\Entities\Donation;
use Modules\Event\Entities\Event;

class EventDatatable
{
    public static function infoColumn($row,$default_lang)
    {
        $output = '<ul class="all_donation_info_column">';
        $output .= '<li><strong>' . __('Title') . ' :</strong> ' . $row->getTranslation('title',$default_lang) . '</li>';
        $output .= '<li><strong>' . __('Event Date') . ' :</strong> ';
        $output .= $row->date ?? '';
        $output .= '<li><strong>' . __('Event Time') . ' :</strong> ';
        $output .= $row->time ?? '';
        $output .= '<li><strong>' . __('Event Cost') . ' :</strong> ';
        $output .= amount_with_currency_symbol($row->cost) ?? 0;
        $output .= '<li><strong>' . __('Organizer') . ' :</strong> ' . $row->organizer . '</li>';
        $output .= '<li><strong>' . __('Venue Location') . ':</strong> ';
        $output .= $row->venue_location;
        $output .= '<li><strong>' . __('Created At') . ' :</strong> ' . date("d-M-Y", strtotime($row->created_at)) . '</li>';
        $output .= '</li>';

        $output .= '<li><strong>' . __('Total Seat') . ' :</strong> ';
        $output .= $row->total_ticket ;
        $output .= '<li><strong>' . __('Available Ticket') . ': </strong> ';
        $output .=  ($row->available_ticket ?? $row->total_ticket) ;

        $output .= '</ul>';
        return $output;
    }


    public static function comments($id)
    {
        $event = Event::find($id);
        $title = __('Event Comments') . __(sprintf(' (%d)',$event->comments?->count()));
        $url = route('tenant.admin.event.comments.view',$id);
        return <<<HTML
        <a href="{$url}"
           class="btn btn-success text-white mb-3 mr-1 btn-sm">{$title}
        </a>
HTML;
    }


    public static function paymentInfoColumn($row){

        $output = '<ul>';
        $output .= '<li><strong>'.__('Event Title').': </strong> '.purify_html(optional($row->event)->getTranslation('title',get_user_lang())).'</li>';
        $output .= '<li><strong>'.__('Ticket Qty').': </strong> '.$row->ticket_qty.'</li>';
        $output .= '<li><strong>'.__('Amount').': </strong> '.amount_with_currency_symbol($row->amount).'</li>';
        $output .= '<li><strong>'.__('Date').': </strong> '.$row->event?->date.'</li>';
        $output .= '<li><strong>'.__('Time').': </strong> '.$row->event?->time.'</li>';
        $output .= '<li><strong>'.__('Location').': </strong> '.$row->event?->venue_location.'</li>';
        $output .= '<li><strong>'.__('Name').': </strong> '.purify_html($row->name).'</li>';
        $output .= '<li><strong>'.__('Email').': </strong> '.purify_html($row->email).'</li>';
        $output .= '<li><strong>'.__('Phone').': </strong> '.purify_html($row->phone).'</li>';

        $output .= '<li><strong>'.__('Payment Gateway').': </strong> '.ucwords(str_replace('_',' ',$row->payment_gateway)).'</li>';
        if ($row->status == 'complete' && $row->payment_gateway != 'manual_payment'){
            $output .= '<li><strong>'.__('Transaction ID').': </strong> '.$row->transaction_id.'</li>';
        }
        $output .= '<li><strong>'.__('Date').': </strong> '.date_format($row->created_at,'d M Y').'</li>';
        $output .= '</ul>';

        return $output;
    }

    public static function get_event_status_with_markup($row)
    {
        $output = '';
        if($row->status == 1){
            $output .= '<li><span class="badge badge-info">'.DonationPaymentStatusEnum::getText($row->status ).'</span> </li>';
        }else{
            $output .= '<li><span class="badge badge-dark">'.DonationPaymentStatusEnum::getText($row->status ).'</span> </li>';
        }

        return $output;
    }




}
