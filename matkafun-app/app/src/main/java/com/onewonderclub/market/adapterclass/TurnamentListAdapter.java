package com.onewonderclub.market.adapterclass;

import android.content.Context;
import android.content.Intent;
import android.os.Handler;
import android.os.Looper;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.TextView;
import java.util.Random;

import androidx.annotation.NonNull;
import androidx.cardview.widget.CardView;
import androidx.core.content.ContextCompat;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.imageview.ShapeableImageView;
import com.google.android.material.textview.MaterialTextView;
import com.kalyankuber.alpha.R;
import com.onewonderclub.market.activityclass.TableActivity;
import com.onewonderclub.market.responseclass.DataGameList;
import com.onewonderclub.market.shareprefclass.SharPrefClass;
import com.romainpiel.shimmer.Shimmer;
import com.romainpiel.shimmer.ShimmerTextView;

import java.util.ArrayList;

public class TurnamentListAdapter extends RecyclerView.Adapter<TurnamentListAdapter.ViewHolder>{

    public interface OnItemClickListener{
        void onItemClick(DataGameList.Data data, View itemView);
    }
    Context context;
    private final ArrayList<DataGameList.Data> datalArrayList;

    private final OnItemClickListener listener;

    public TurnamentListAdapter(Context context, ArrayList<DataGameList.Data> datalArrayList, OnItemClickListener listener) {
        this.context = context;
        this.datalArrayList = datalArrayList;
        this.listener = listener;
    }

    @NonNull
    @Override
    public TurnamentListAdapter.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.turnament_layout, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull TurnamentListAdapter.ViewHolder holder, int position) {
        holder.attach(datalArrayList.get(position), listener, context, position);
    }

    @Override
    public int getItemCount() {
        return datalArrayList.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        private final MaterialTextView eventNumber;
        private final MaterialTextView openingTime;
        private final MaterialTextView closingTime;
        private final MaterialTextView marketOpen;
        private final ShapeableImageView chartTable;
        private final ShapeableImageView eventStatus;
        private final CardView eventStatusContainer;
        private final ShimmerTextView eventType;
        private final TextView tvActiveUsers;
        private final View activeUsersRow;

        // State for the active-users ticker
        private int activeCount = 0;
        private final Handler tickHandler = new Handler(Looper.getMainLooper());
        private Runnable tickRunnable;
        private final Random random = new Random();

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            eventType = itemView.findViewById(R.id.eventType);
            eventNumber = itemView.findViewById(R.id.eventNumber);
            eventStatus = itemView.findViewById(R.id.eventStatus);
            eventStatusContainer = itemView.findViewById(R.id.eventStatusContainer);
            openingTime = itemView.findViewById(R.id.openingTime);
            closingTime = itemView.findViewById(R.id.closingTime);
            chartTable = itemView.findViewById(R.id.chartTable);
            marketOpen = itemView.findViewById(R.id.marketOpen);
            tvActiveUsers = itemView.findViewById(R.id.tvActiveUsers);
            activeUsersRow = itemView.findViewById(R.id.activeUsersRow);
            Shimmer shimmer = new Shimmer();
            shimmer.start(eventType);
        }

        public void attach(DataGameList.Data data, OnItemClickListener listener, Context context, int position) {
            if (!SharPrefClass.getLiveUser(context)){
                eventStatus.setImageResource(R.drawable.chart_icon);
                if (eventStatusContainer != null) {
                    eventStatusContainer.setCardBackgroundColor(ContextCompat.getColor(context, R.color.red));
                }
                eventStatus.setOnClickListener(v -> {

                    Intent intent = new Intent(context, TableActivity.class);
                    intent.putExtra(context.getString(R.string.chart), data.getChart_url());
                    context.startActivity(intent);
                });
                marketOpen.setVisibility(View.GONE);

            }else {
                marketOpen.setVisibility(View.VISIBLE);
                if (data.isMarket_open() && data.isPlay()){
                    eventStatus.setImageResource(R.drawable.play_icon);
                    if (eventStatusContainer != null) {
                        eventStatusContainer.setCardBackgroundColor(ContextCompat.getColor(context, R.color.green));
                    }
                    marketOpen.setText("Market is Running");
                    marketOpen.setBackgroundColor(ContextCompat.getColor(context, R.color.white));
                    marketOpen.setTextColor(ContextCompat.getColor(context, R.color.green));
                }else {
                    eventStatus.setImageResource(R.drawable.close_icon);
                    if (eventStatusContainer != null) {
                        eventStatusContainer.setCardBackgroundColor(ContextCompat.getColor(context, R.color.red));
                    }
                    marketOpen.setText("Market Closed");
                    marketOpen.setBackgroundColor(ContextCompat.getColor(context, R.color.white));
                    marketOpen.setTextColor(ContextCompat.getColor(context, R.color.red));
                }
                userDataMethod(data);
            }

            eventType.setText(data.getName());
            openingTime.setText(data.getOpen_time());
            closingTime.setText(data.getClose_time());
            eventNumber.setText(data.getResult());
            itemView.setOnClickListener(v ->{
                if(SharPrefClass.getLiveUser(context)){
                    listener.onItemClick(data, v);
                }
            });

            chartTable.setOnClickListener(v -> {
                Intent intent = new Intent(context, TableActivity.class);
                intent.putExtra(context.getString(R.string.chart), data.getChart_url());
                context.startActivity(intent);
            });

            // Show active users count only when market is open
            if (data.isMarket_open() && data.isPlay()) {
                activeUsersRow.setVisibility(View.VISIBLE);
                startActiveUsersTicker(position);
                
                // Add dot blink animation
                View dot = activeUsersRow.findViewWithTag("activeDot");
                if (dot == null) {
                    dot = ((ViewGroup)activeUsersRow).getChildAt(0); // Assuming dot is the first child
                }
                Animation blink = AnimationUtils.loadAnimation(context, R.anim.blink);
                if (dot != null) {
                    dot.startAnimation(blink);
                }
            } else {
                activeUsersRow.setVisibility(View.GONE);
                if (tickRunnable != null) {
                    tickHandler.removeCallbacks(tickRunnable);
                }
            }
        }

        private void startActiveUsersTicker(int position) {
            // Stop any previous runnable for this ViewHolder (recycling)
            if (tickRunnable != null) {
                tickHandler.removeCallbacks(tickRunnable);
            }

            // Seed a unique starting count per card: 1,000 – 2,500 range, slightly offset by position
            if (activeCount == 0) {
                activeCount = 1000 + random.nextInt(1500) + (position * 37);
            }
            updateActiveUsersText();

            tickRunnable = new Runnable() {
                @Override
                public void run() {
                    // Increase by 1–4 every 3–7 seconds — believable slow growth
                    int change = random.nextInt(4) + 1;
                    // Occasionally (1 in 8 chance) reduce by 1 so it feels organic
                    if (random.nextInt(8) == 0 && activeCount > 1010) {
                        activeCount -= 1;
                    } else {
                        activeCount += change;
                    }
                    updateActiveUsersText();
                    // Schedule next tick between 3 and 7 seconds
                    long delay = 3000 + random.nextInt(4000);
                    tickHandler.postDelayed(this, delay);
                }
            };
            tickHandler.postDelayed(tickRunnable, 3000 + random.nextInt(3000));
        }

        private void updateActiveUsersText() {
            // Format with comma for thousands: e.g. 1,024
            String formatted = String.format("%,d", activeCount);
            tvActiveUsers.setText(formatted + " Players Active");
        }

        private void userDataMethod(DataGameList.Data data) {
            eventType.setText(data.getName());
            openingTime.setText(data.getOpen_time());
            closingTime.setText(data.getClose_time());
            eventNumber.setText(data.getResult());

            if (data.isMarket_open() && data.isPlay()){
                eventStatus.setImageResource(R.drawable.play_icon);
                if (eventStatusContainer != null) {
                    eventStatusContainer.setCardBackgroundColor(ContextCompat.getColor(context, R.color.green));
                }
                marketOpen.setText("Market is Running");
                marketOpen.setBackgroundColor(ContextCompat.getColor(context, R.color.white));
                marketOpen.setTextColor(ContextCompat.getColor(context, R.color.green));
            }else {
                eventStatus.setImageResource(R.drawable.close_icon);
                if (eventStatusContainer != null) {
                    eventStatusContainer.setCardBackgroundColor(ContextCompat.getColor(context, R.color.red));
                }
                marketOpen.setText("Market Closed");
                marketOpen.setBackgroundColor(ContextCompat.getColor(context, R.color.white));
                marketOpen.setTextColor(ContextCompat.getColor(context, R.color.red));
            }
            Animation  animation = AnimationUtils.loadAnimation(context, R.anim.move);
            eventNumber.setAnimation(animation);
        }
    }
}
