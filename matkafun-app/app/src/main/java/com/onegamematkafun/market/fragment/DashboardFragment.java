package com.onegamematkafun.market.fragment;

import android.Manifest;
import android.animation.ObjectAnimator;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.Vibrator;
import android.text.TextUtils;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import com.google.android.material.card.MaterialCardView;
import com.onegamematkafun.market.adapterclass.RecentWinnersAdapter;
import androidx.core.app.ActivityCompat;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.viewpager.widget.ViewPager;

import com.google.android.material.textview.MaterialTextView;
import com.kalyankuber.alpha.R;
import com.onegamematkafun.market.activityclass.AddCoinActivity;
import com.onegamematkafun.market.activityclass.TakeOutActivity;
import com.onegamematkafun.market.activityclass.DashboardActivity;
import com.onegamematkafun.market.activityclass.DisawarActivity;
import com.onegamematkafun.market.activityclass.TurnamentActivity;
import com.onegamematkafun.market.activityclass.UserInfoActivity;
import com.onegamematkafun.market.activityclass.WebSiteActivity;
import com.onegamematkafun.market.adapterclass.TurnamentListAdapter;
import com.onegamematkafun.market.adapterclass.ViewPagerAdapter;
import com.onegamematkafun.market.responseclass.DataGameList;
import com.onegamematkafun.market.shareprefclass.SharPrefClass;

import java.util.ArrayList;
import java.util.List;
import java.util.Timer;
import java.util.TimerTask;

public class DashboardFragment extends Fragment {

    public static MaterialTextView marqueText, user_name;
    private View whatsappBtn, telegramBtn, user_profile;
    ViewPager mViewPager;
    ViewPagerAdapter mViewPagerAdapter;
    static FrameLayout mViewPagFrame;
    static FrameLayout stripLayout;
    static RelativeLayout phoneLyt;
    static LinearLayout aaa, quick_actions;
    private static RelativeLayout galli_disawar_section;
    private View wallet_item;
    private static RecyclerView recyView;
    private static TurnamentListAdapter turnamentListAdapter;
    public static List<DataGameList.Data> mDataList = new ArrayList<>();
    private ProgressBar mProgressBar;
    private Context context;
    private static Context mContext;
    private static Vibrator mVibe;
    int mCurrentPage = 0;
    long DELAY_MS = 1000;
    long PERIOD_MS = 2000;
    private String[] mImages;

    static TextView whatsppTv, telegramTv;
    private static RelativeLayout dpboss_rl;
    private RelativeLayout telegram_item;
    private static RelativeLayout addpoints_item;
    private static RelativeLayout whatsapp_item;
    private static RelativeLayout withdraw_op;
    private static RelativeLayout starline_item;
    private static RelativeLayout galli_diswar_item;
    private MaterialCardView recentWinnersCard;
    private RecyclerView recentWinnersRecyclerView;
    private final Handler scrollHandler = new Handler();
    private Runnable scrollRunnable;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_dashboard, container, false);
        mContext = view.getContext();
        intVariables(view);
        loadData(context);
        clickListeners(context);
        confViewPager(context, mImages);
        return view;
    }
    
    private void clickListeners(Context context) {

        String whatsappNum = SharPrefClass.getContactObject(context, SharPrefClass.KEY_WHATSAP_NUMBER);
        whatsppTv.setText(getSafePhone(whatsappNum));

        String telegramLink = SharPrefClass.getContactObject(context, SharPrefClass.KEY_TELEGRAM_LINK);
        telegramTv.setText("Telegram");

        whatsapp_item.setOnClickListener(v -> {
            DashboardActivity.viewPager.setCurrentItem(1, true);
        });

        dpboss_rl.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(context, WebSiteActivity.class);
                context.startActivity(intent);

            }
        });

        telegram_item.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getActivity(), DisawarActivity.class);
                startActivity(intent);
            }
        });

        starline_item.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                DashboardActivity.viewPager.setCurrentItem(1,true);
            }
        });

        addpoints_item.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getActivity(), AddCoinActivity.class);
                startActivity(intent);
            }
        });

        withdraw_op.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getActivity(), TakeOutActivity.class);
                intent.putExtra("SHOW_TERMS", true);
                startActivity(intent);
            }
        });

        galli_diswar_item.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //DashboardActivity.viewPager.setCurrentItem(4,true);

                Intent intent = new Intent(getActivity(), DisawarActivity.class);
                startActivity(intent);
            }
        });

        whatsappBtn.setOnClickListener(v -> {
            String msg = "Hello Sir\nMy Name : " +
                    SharPrefClass.getPrfrnceinfo(context, SharPrefClass.KEY_USER_NAME) +
                    "\nMy Number : " +
                    SharPrefClass.getPrfrnceinfo(context, SharPrefClass.KEY_PHONE_NUMBER);

            String url = "https://api.whatsapp.com/send?phone="+SharPrefClass.getContactObject(context, SharPrefClass.KEY_WHATSAP_NUMBER)+"&text="+msg;
            Intent i = new Intent(Intent.ACTION_VIEW);

            i.setData(Uri.parse(url));
            startActivity(i);
        });

        telegramBtn.setOnClickListener(v -> {
            String tLink = SharPrefClass.getContactObject(context, SharPrefClass.KEY_TELEGRAM_LINK);
            if (tLink != null && !tLink.isEmpty()) {
                Intent i = new Intent(Intent.ACTION_VIEW, Uri.parse(tLink));
                startActivity(i);
            }
        });

        if (user_profile != null) {
            user_profile.setOnClickListener(v -> {
                Intent profile = new Intent(context, UserInfoActivity.class);
                startActivity(profile);
            });
        }

        if (wallet_item != null) {
            wallet_item.setOnClickListener(v -> {
                DashboardActivity.viewPager.setCurrentItem(2, true);
            });
        }
    }

    private void loadData(Context context) {
        marqueText.setText(SharPrefClass.getPrfrnceinfo(context, SharPrefClass.KEY_MAR_TXT));
        marqueText.setEllipsize(TextUtils.TruncateAt.MARQUEE);
        marqueText.setSelected(true);
        marqueText.setSingleLine(true);
        marqueText.setMarqueeRepeatLimit(-1);
        mVibe = (Vibrator) context.getSystemService(Context.VIBRATOR_SERVICE);
        mImages = new String[]{SharPrefClass.getPosterImage(context, SharPrefClass.KEY_POSTER_IMAGES1),
                SharPrefClass.getPosterImage(context, SharPrefClass.KEY_POSTER_IMAGES2),
                SharPrefClass.getPosterImage(context, SharPrefClass.KEY_POSTER_IMAGES3)};

        if (whatsppTv != null) {
            String wNum = SharPrefClass.getContactObject(context, SharPrefClass.KEY_WHATSAP_NUMBER);
            if (wNum != null && wNum.length() > 10) {
                wNum = wNum.substring(wNum.length() - 10);
            } else if (wNum == null) {
                wNum = "";
            }
            whatsppTv.setText(wNum);
        }

        fetchRecentWinners();
    }

    private void fetchRecentWinners() {
        String token = SharPrefClass.getLoginInToken(context);
        if (token == null || token.isEmpty()) return;

        com.onegamematkafun.market.apiclass.ApiClass.getClient().getTopWinners(token, "").enqueue(new retrofit2.Callback<com.onegamematkafun.market.responseclass.DataTopWinners>() {
            @Override
            public void onResponse(retrofit2.Call<com.onegamematkafun.market.responseclass.DataTopWinners> call, retrofit2.Response<com.onegamematkafun.market.responseclass.DataTopWinners> response) {
                if (response.isSuccessful() && response.body() != null) {
                    com.onegamematkafun.market.responseclass.DataTopWinners resp = response.body();
                    if ("100".equals(resp.getCode()) && resp.getData() != null && !resp.getData().isEmpty()) {
                        recentWinnersCard.setVisibility(View.VISIBLE);
                        
                        RecentWinnersAdapter adapter = new RecentWinnersAdapter(context, resp.getData());
                        LinearLayoutManager layoutManager = new LinearLayoutManager(context);
                        recentWinnersRecyclerView.setLayoutManager(layoutManager);
                        recentWinnersRecyclerView.setAdapter(adapter);

                        if (scrollRunnable != null) {
                            scrollHandler.removeCallbacks(scrollRunnable);
                        }
                        
                        // Disable manual scrolling to enforce auto-scroll feel (optional, but requested infinite flow)
                        recentWinnersRecyclerView.setOnTouchListener((v, event) -> true);

                        scrollRunnable = new Runnable() {
                            @Override
                            public void run() {
                                if (recentWinnersRecyclerView != null) {
                                    // Use 'scrollBy' for constant velocity, stutter-free continuous flow
                                    recentWinnersRecyclerView.scrollBy(0, 2);
                                    // Run every ~16ms for solid 60fps smooth rendering
                                    scrollHandler.postDelayed(this, 16);
                                }
                            }
                        };
                        scrollHandler.postDelayed(scrollRunnable, 1000);

                    } else {
                        recentWinnersCard.setVisibility(View.GONE);
                    }
                }
            }

            @Override
            public void onFailure(retrofit2.Call<com.onegamematkafun.market.responseclass.DataTopWinners> call, Throwable t) {
                Log.e("fetchRecentWinners", "Error: " + t.getMessage());
            }
        });
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        if (scrollHandler != null && scrollRunnable != null) {
            scrollHandler.removeCallbacks(scrollRunnable);
        }
    }

    private String getSafePhone(String phone) {
        if (phone == null || phone.isEmpty()) return "";
        if (phone.length() > 10) {
            return phone.substring(phone.length() - 10);
        }
        return phone;
    }

    private void intVariables(View view) {
        context = view.getContext();
        mViewPager = view.findViewById(R.id.viewPager);
        mViewPagFrame = view.findViewById(R.id.viewPagerFrame);
        recyView = view.findViewById(R.id.recyclerView);
        telegramBtn = view.findViewById(R.id.telegramBtn);
        marqueText = view.findViewById(R.id.text_marque);
        mProgressBar = view.findViewById(R.id.progressBar);
        stripLayout = view.findViewById(R.id.stripLayout);
        phoneLyt = view.findViewById(R.id.phoneLyt);
        dpboss_rl = view.findViewById(R.id.dpboss_rl);
        whatsapp_item= view.findViewById(R.id.whatsapp_item);
        whatsppTv= view.findViewById(R.id.whatsapp_contact_text);
        telegramTv = view.findViewById(R.id.telegram_tv);

        whatsappBtn = view.findViewById(R.id.whatsappBtn);
        user_profile = null; // No profile button on dashboard currently
        user_name = view.findViewById(R.id.user_name);


        telegram_item= view.findViewById(R.id.telegram_item);
        addpoints_item= view.findViewById(R.id.addpoints_item);
        withdraw_op= view.findViewById(R.id.withdraw_op);
        starline_item= view.findViewById(R.id.starline_item);
        galli_diswar_item= view.findViewById(R.id.galli_item);
        aaa = view.findViewById(R.id.aaa);
        recentWinnersCard = view.findViewById(R.id.recentWinnersCard);
        recentWinnersRecyclerView = view.findViewById(R.id.recentWinnersRecyclerView);
//        quick_actions = view.findViewById(R.id.quick_actions);
        // galli_disawar_section = view.findViewById(R.id.galli_disawar_section);
        // wallet_item = view.findViewById(R.id.wallet_item);
        confiView();
    }

    private static void confiView() {
        if (SharPrefClass.getSharedBooleanStatus(mContext, SharPrefClass.KEY_DEVELOPER_MODE)){
            phoneLyt.setVisibility(View.GONE);
            mViewPagFrame.setVisibility(View.GONE);
            stripLayout.setVisibility(View.GONE);
            aaa.setVisibility(View.GONE);
        }else {
            phoneLyt.setVisibility(View.VISIBLE);
            mViewPagFrame.setVisibility(View.GONE);
            stripLayout.setVisibility(View.VISIBLE);

            // Show main button container
            aaa.setVisibility(View.VISIBLE);
        }
        
        if(SharPrefClass.getLiveUser(mContext)){
            // Show Gali Disawar
            galli_diswar_item.setVisibility(View.VISIBLE);
            
            // Hide Jackpot and Result Prediction
            starline_item.setVisibility(View.GONE);
            dpboss_rl.setVisibility(View.GONE);
            
            addpoints_item.setVisibility(View.VISIBLE);
            whatsapp_item.setVisibility(View.VISIBLE);
            withdraw_op.setVisibility(View.VISIBLE);
        }else{
            galli_diswar_item.setVisibility(View.GONE);
            
            // Hide Jackpot and Result Prediction
            starline_item.setVisibility(View.GONE);
            dpboss_rl.setVisibility(View.GONE);
            
            addpoints_item.setVisibility(View.VISIBLE);
            whatsapp_item.setVisibility(View.VISIBLE);
            withdraw_op.setVisibility(View.VISIBLE);
        }
    }

    public void confViewPager(Context context, String[] images) {
        WindowManager windowManager = (WindowManager) context.getSystemService(Context.WINDOW_SERVICE);
        DisplayMetrics displayMetrics = new DisplayMetrics();
        windowManager.getDefaultDisplay().getMetrics(displayMetrics);
        int width = displayMetrics.widthPixels;
        double imageHeight = width*0.40;
        mViewPagFrame.getLayoutParams().height= (int) imageHeight;

        mViewPagerAdapter = new ViewPagerAdapter(context, images);
        mViewPager.setAdapter(mViewPagerAdapter);
        final Handler handler = new Handler();
        final Runnable Update = () -> {
            if (mCurrentPage == 3) {
                mCurrentPage = 0;
            }
            mViewPager.setCurrentItem(mCurrentPage++, true);
        };

        Timer mTimer = new Timer();
        mTimer.schedule(new TimerTask() { // task to be scheduled
            @Override
            public void run() {
                handler.post(Update);
            }
        }, DELAY_MS, PERIOD_MS);
    }

    public static void confRecyView(Context activity) {
        turnamentListAdapter = new TurnamentListAdapter(activity, (ArrayList<DataGameList.Data>) mDataList, (data, itemView) -> {
            if (!data.isPlay()){
                ObjectAnimator
                        .ofFloat(itemView, "translationX", 0, 25, -25, 25, -25,15, -15, 6, -6, 0)
                        .setDuration(700)
                        .start();
                mVibe.vibrate(500);
            }else {
                Intent intent = new Intent(activity, TurnamentActivity.class);
                intent.putExtra(activity.getString(R.string.game), data.getId());
                intent.putExtra("open",data.isOpen());
                activity.startActivity(intent);
            }
        });
        LinearLayoutManager layoutManager = new LinearLayoutManager(activity);
        recyView.setLayoutManager(layoutManager);
        recyView.setAdapter(turnamentListAdapter);
    }

    private void showWithdrawTermsDialog() {
        android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(mContext);
        LayoutInflater inflater = LayoutInflater.from(mContext);
        View dialogView = inflater.inflate(R.layout.dialog_withdraw_terms, null);
        builder.setView(dialogView);

        MaterialTextView minWithdrawText = dialogView.findViewById(R.id.minWithdrawText);
        MaterialTextView maxWithdrawText = dialogView.findViewById(R.id.maxWithdrawText);
        MaterialTextView withdrawTimingText = dialogView.findViewById(R.id.withdrawTimingText);

        String minW = SharPrefClass.getMaxMinObject(mContext, SharPrefClass.KEY_MIN_EXTRACT_COINS);
        String maxW = SharPrefClass.getMaxMinObject(mContext, SharPrefClass.KEY_MAX_EXTRACT_COINS);
        String openT = SharPrefClass.getMaxMinObject(mContext, SharPrefClass.KEY_WITHDRAW_OPEN_TIME);
        String closeT = SharPrefClass.getMaxMinObject(mContext, SharPrefClass.KEY_WITHDRAW_CLOSE_TIME);

        if (minW != null) minWithdrawText.setText("\u2022 Minimum Withdrawal ₹" + minW + "/-");
        if (maxW != null) maxWithdrawText.setText("\u2022 Maximum Withdrawal ₹" + maxW + "/- per day");
        if (openT != null && closeT != null) {
            withdrawTimingText.setText("\u2022 Withdrawal Timing ⏰ " + openT + " \u2013 " + closeT);
        }

        final android.app.AlertDialog dialog = builder.create();
        dialog.setCancelable(false);

        // Make background transparent for rounded corners
        if (dialog.getWindow() != null) {
            dialog.getWindow().setBackgroundDrawable(new android.graphics.drawable.ColorDrawable(android.graphics.Color.TRANSPARENT));
        }

        View btnAccept = dialogView.findViewById(R.id.btnAccept);
        btnAccept.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog.dismiss();
                Intent intent = new Intent(getActivity(), TakeOutActivity.class);
                startActivity(intent);
            }
        });

        dialog.show();
    }

    public static void recall() {
        if (mContext != null) {
            confiView();
            if (marqueText != null) {
                String mText = SharPrefClass.getPrfrnceinfo(mContext, SharPrefClass.KEY_MAR_TXT);
                marqueText.setText(mText);
                marqueText.setSelected(true);
            }
            if (whatsppTv != null) {
                String wNum = SharPrefClass.getContactObject(mContext, SharPrefClass.KEY_WHATSAP_NUMBER);
                if (wNum != null && wNum.length() > 10) {
                    wNum = wNum.substring(wNum.length() - 10);
                } else if (wNum == null) {
                    wNum = "";
                }
                whatsppTv.setText(wNum);
            }
        }
    }
}