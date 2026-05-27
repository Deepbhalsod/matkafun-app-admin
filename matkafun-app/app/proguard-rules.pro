# =============================
# General Project Rules
# =============================


-keepattributes JavascriptInterface
-keepattributes *Annotation*

# Preserve line numbers for better crash reports
-keepattributes SourceFile,LineNumberTable

# Don’t warn about Razorpay
-dontwarn com.razorpay.**
-keep class com.razorpay.** { *; }

# Payment callbacks
-optimizations !method/inlining/*
-keepclasseswithmembers class * {
    public void onPayment*(...);
}

# =============================
# App-specific classes
# =============================

# Your response models
-keep class com.onegamematkafun.market.responseclass.** { *; }

# =============================
# Firebase / Play Services
# =============================
-keep class com.google.firebase.** { *; }
-dontwarn com.google.firebase.**
-keep class com.google.android.gms.** { *; }
-dontwarn com.google.android.gms.**

# =============================
# Jetpack / AndroidX
# =============================
-keep class androidx.lifecycle.** { *; }
-dontwarn androidx.lifecycle.**
-keep class androidx.annotation.Keep

# Compose (runtime reflection)
-keep class androidx.compose.** { *; }
-dontwarn androidx.compose.**

# ViewModel / SavedState
-keepclassmembers class * extends androidx.lifecycle.ViewModel {
    <init>(...);
}

# =============================
# Retrofit / OkHttp / Gson / Moshi
# =============================

# Retrofit interfaces
-keep interface com.onegamematkafun.market.api.** { *; }
-keep interface retrofit2.** { *; }
-dontwarn retrofit2.**

# OkHttp
-dontwarn okhttp3.**
-keep class okhttp3.** { *; }

# Gson model classes (add your model package here)
-keep class com.onegamematkafun.market.models.** { *; }

# Moshi
-dontwarn com.squareup.moshi.**
-keep class com.squareup.moshi.** { *; }

# =============================
# Hilt / Dagger
# =============================
-keep class dagger.hilt.** { *; }
-dontwarn dagger.hilt.**
-keep class javax.inject.** { *; }
-dontwarn javax.inject.**



# =============================
# END
# =============================
