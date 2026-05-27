package com.onegamematkafun.market.apiclass;

import android.app.Activity;
import com.google.android.material.dialog.MaterialAlertDialogBuilder;
import androidx.appcompat.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.util.Log;

import com.kalyankuber.alpha.BuildConfig;
import com.onegamematkafun.market.responseclass.UpdateResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class UpdateChecker {

    public interface OnUpdateFinishedListener {
        void onContinue();
    }

    private static final String TAG = "UpdateChecker";
    private static boolean isDialogShowing = false;
    private final Context context;
    private final String updateUrl;
    private OnUpdateFinishedListener listener;

    public UpdateChecker(Context context, String updateUrl, OnUpdateFinishedListener listener) {
        this.context = context;
        this.updateUrl = updateUrl;
        this.listener = listener;
    }

    public void checkForUpdate() {
        ApiInterface apiService = ApiClass.getClient();
        Call<UpdateResponse> call = apiService.getInAppUpdate(updateUrl);

        call.enqueue(new Callback<UpdateResponse>() {
            @Override
            public void onResponse(Call<UpdateResponse> call, Response<UpdateResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    UpdateResponse updateResponse = response.body();
                    validateUpdate(updateResponse);
                } else {
                    Log.e(TAG, "Update check failed: " + response.message());
                    isDialogShowing = false;
                    if (listener != null) listener.onContinue();
                }
            }

            @Override
            public void onFailure(Call<UpdateResponse> call, Throwable t) {
                Log.e(TAG, "Update check error: " + t.getMessage());
                isDialogShowing = false;
                if (listener != null) listener.onContinue();
            }
        });
    }

    private void validateUpdate(UpdateResponse updateResponse) {
        String currentVersion = BuildConfig.VERSION_NAME;
        String latestVersion = updateResponse.getLatestVersion();
        String minVersion = updateResponse.getMinSupportedVersion();

        boolean isUpdateAvailable = compareVersions(currentVersion, latestVersion) < 0;
        
        if (isUpdateAvailable) {
            // Determine if it should be forced
            boolean isUpdateForced = (compareVersions(currentVersion, minVersion) < 0) || 
                                     updateResponse.isUpdateForced();
            
            showUpdateDialog(updateResponse, isUpdateForced);
        } else {
            isDialogShowing = false;
            if (listener != null) listener.onContinue();
        }
    }

    private int compareVersions(String v1, String v2) {
        if (v1 == null || v2 == null) return 0;
        String[] components1 = v1.split("\\.");
        String[] components2 = v2.split("\\.");
        int length = Math.max(components1.length, components2.length);
        for (int i = 0; i < length; i++) {
            try {
                int d1 = i < components1.length ? Integer.parseInt(components1[i]) : 0;
                int d2 = i < components2.length ? Integer.parseInt(components2[i]) : 0;
                if (d1 < d2) return -1;
                if (d1 > d2) return 1;
            } catch (NumberFormatException e) {
                Log.e(TAG, "Invalid version format: " + v1 + " or " + v2);
                return 0;
            }
        }
        return 0;
    }

    private void showUpdateDialog(final UpdateResponse updateResponse, final boolean isForceUpdate) {
        if (!(context instanceof Activity)) {
            if (listener != null) listener.onContinue();
            return;
        }

        // Prevent duplicate dialogs
        if (isDialogShowing) {
            return;
        }
        isDialogShowing = true;

        MaterialAlertDialogBuilder builder = new MaterialAlertDialogBuilder(context);
        builder.setTitle("Update Available");
        builder.setMessage(updateResponse.getUpdateMessage());
        
        // Disable click outside for BOTH optional and forced
        builder.setCancelable(false);

        builder.setPositiveButton("Update Now", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                // Do NOT reset isDialogShowing here if it's forced, to prevent re-triggering during close
                if (!isForceUpdate) {
                    isDialogShowing = false;
                }
                openPlayStore(updateResponse.getUpdateUrl());
                if (isForceUpdate) {
                    ((Activity) context).finishAffinity(); // Close app completely
                }
            }
        });

        if (!isForceUpdate) {
            builder.setNegativeButton("Later", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    isDialogShowing = false;
                    dialog.dismiss();
                    if (listener != null) listener.onContinue();
                }
            });
        }

        AlertDialog dialog = builder.create();
        dialog.setCanceledOnTouchOutside(false); // Extra safety to disable outside click
        
        try {
            dialog.show();
        } catch (Exception e) {
            Log.e(TAG, "Error showing dialog: " + e.getMessage());
            isDialogShowing = false;
            if (listener != null) listener.onContinue();
        }
    }

    private void openPlayStore(String url) {
        try {
            Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
            context.startActivity(intent);
        } catch (Exception e) {
            Log.e(TAG, "Could not open Play Store: " + e.getMessage());
        }
    }
}
