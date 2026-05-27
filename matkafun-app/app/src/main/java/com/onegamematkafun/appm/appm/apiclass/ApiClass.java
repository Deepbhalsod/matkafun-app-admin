package com.onegamematkafun.appm.appm.apiclass;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.util.Arrays;

import okhttp3.ConnectionSpec;
import okhttp3.OkHttpClient;
import okhttp3.TlsVersion;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class ApiClass {

    private static final ApiClass instance = null;
    private static ApiInterface retrofit;
    private static final OkHttpClient.Builder builder = new OkHttpClient.Builder();
    private static final HttpLoggingInterceptor interceptor = new HttpLoggingInterceptor();

    public static ApiInterface getClient() {


        Gson gson = new GsonBuilder()
                .setLenient()
                .create();
        interceptor.level(HttpLoggingInterceptor.Level.BODY);
        builder.addInterceptor(interceptor);


        if(retrofit==null){
            // ✅ Enable modern TLS protocols (1.2 / 1.3)
            ConnectionSpec spec = new ConnectionSpec.Builder(ConnectionSpec.MODERN_TLS)
                    .tlsVersions(TlsVersion.TLS_1_2, TlsVersion.TLS_1_3)
                    .allEnabledCipherSuites()
                    .build();

            builder.connectionSpecs(Arrays.asList(spec, ConnectionSpec.CLEARTEXT));

            retrofit = new Retrofit.Builder()
                    .baseUrl(ApiUrls.BASE_URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .client(builder.build())
                    .build().create(ApiInterface.class);
        }
        return retrofit;
    }
}
