
public class SessionAddActivity extends AppCompatActivity {
	
	private text session_name;
				private text session_detail;
				private EditText start_date;
				private EditText end_date;
				private Button btn_add_sessions;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_add_session);
		
		session_name = (text)findViewById(R.id.session_name);
				session_detail = (text)findViewById(R.id.session_detail);
				start_date = (EditText)findViewById(R.id.start_date);
				end_date = (EditText)findViewById(R.id.end_date);
				btn_add_sessions = (Button)findViewById(R.id.btn_add_sessions);
		
		
btn_add_sessions.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //do your code here
				final String form_session_name = session_name.getText().toString();
				final String form_session_detail = session_detail.getText().toString();
				final String form_start_date = start_date.getText().toString();
				final String form_end_date = end_date.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(SessionAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/session/save_data", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(SessionAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(SessionAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("session_name", form_session_name);
				params.put("session_detail", form_session_detail);
				params.put("start_date", form_start_date);
				params.put("end_date", form_end_date);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		

     }

}
