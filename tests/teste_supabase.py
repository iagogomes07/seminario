from banco import supabase

resultado = supabase.table("tarefas").select("*").execute()

print(resultado.data)