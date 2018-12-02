UndertaleFont font = Selected as UndertaleFont;
using(StreamReader reader = new StreamReader("Fonts\\glyphs_"+font.Name.Content+".csv"))
{
	font.Glyphs.Clear();
	string line;
	while((line = reader.ReadLine()) != null)
	{
		string[] s = line.Split(';');
		font.Glyphs.Add(new UndertaleFont.Glyph() {
			Character = UInt16.Parse(s[0]),
			SourceX = UInt16.Parse(s[1]),
			SourceY = UInt16.Parse(s[2]),
			SourceWidth = UInt16.Parse(s[3]),
			SourceHeight = UInt16.Parse(s[4]),
			Shift = Int16.Parse(s[5]),
			Offset = Int32.Parse(s[6]),
		});
	}
}

ScriptMessage(font.Name.Content+" imported!");