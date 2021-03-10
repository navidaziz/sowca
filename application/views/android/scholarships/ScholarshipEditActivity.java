
public class ScholarshipEditActivity extends AppCompatActivity {
	
	private text scholarship_name;
				private text scholarship_detail;
				private EditText scholarship_value;
				private Button btn_update_scholarships;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_edit_scholarship);
		
		scholarship_name = (text)findViewById(R.id.scholarship_name);
				scholarship_detail = (text)findViewById(R.id.scholarship_detail);
				scholarship_value = (EditText)findViewById(R.id.scholarship_value);
				btn_edit_scholarships = (Button)findViewById(R.id.btn_update_scholarships);
		
		
		
		Intent intent = getIntent();
		String id = intent.getStringExtra("id");
		
		RequestQueue request_queue = Volley.newRequestQueue(ScholarshipEditActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/scholarship/view_scholarship/"+id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									scholarship_name.setText(json_object.getString("scholarship_name"));
				scholarship_detail.setText(json_object.getString("scholarship_detail"));
				scholarship_value.setText(json_object.getString("scholarship_value"));
				
			
								}
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							 //   Toast.makeText(MainActivity.this, "error", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(ScholarshipAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);



	
btn_update_scholarships.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
              final String form_scholarship_name = scholarship_name.getText().toString();
				final String form_scholarship_detail = scholarship_detail.getText().toString();
				final String form_scholarship_value = scholarship_value.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(ScholarshipAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, url+"/mobile/scholarship/save_data/"+form_scholarship_id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(ScholarshipAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(ScholarshipAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("scholarship_name", form_scholarship_name);
				params.put("scholarship_detail", form_scholarship_detail);
				params.put("scholarship_value", form_scholarship_value);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		
        
    }

}
