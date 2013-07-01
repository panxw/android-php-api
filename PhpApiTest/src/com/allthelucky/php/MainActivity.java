package com.allthelucky.php;

import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.os.Bundle;

import com.app.library.http.RequestListener;
import com.app.library.http.RequestManager;

/**
 * PHP接口API测试
 * 
 * @author savant-pan
 * 
 */
public class MainActivity extends Activity {
	private static final String API_URL = "http://www.youth168.com/php_api.php";

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);

		requestApiTest();
	}

	/**
	 * JSONObject方式请求
	 */
	private void requestApiTest() {
		final JSONObject params = new JSONObject();
		try {
			final JSONObject info = new JSONObject();
			info.put("username", "savant-pan");
			info.put("password", "e10adc3949ba59abbe56e057f20f883e");
			info.put("type", "1");

			params.put("information", info);
			params.put("service", "add_user");
		} catch (JSONException e) {
			e.printStackTrace();
		}

		final RequestListener requestListener = new RequestListener() {
			@Override
			public void onStart() {
			}

			@Override
			public void onCompleted(byte[] data, int statusCode, String description, int actionId) {
				if(data!=null) {
					String result = new String(data);
					System.out.println("result:" + result);
				} else {
					System.out.println("error");
				}
				
			}
		};
		RequestManager.getInstance().post(this, API_URL, params, requestListener, 0);
	}

}
