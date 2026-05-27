package com.onewonderclub.market.activityclass;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import com.kalyankuber.alpha.R;
import com.onewonderclub.market.responseclass.DataNotification;
import java.util.ArrayList;

public class NotificationAdapter extends ArrayAdapter<DataNotification> {

    public NotificationAdapter(Context context, ArrayList<DataNotification> notifications) {
        super(context, 0, notifications);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            convertView = LayoutInflater.from(getContext()).inflate(R.layout.item_notification, parent, false);
        }

        DataNotification notification = getItem(position);

        ImageView icon = convertView.findViewById(R.id.icon);
        TextView title = convertView.findViewById(R.id.title);
        TextView message = convertView.findViewById(R.id.message);
        TextView time = convertView.findViewById(R.id.time);

        icon.setImageResource(R.drawable.noti);
        if (notification != null) {
            title.setText(notification.getTitle());
            message.setText(notification.getMessage());
            time.setText(notification.getCreatedAt());
        }

        return convertView;
    }
}
